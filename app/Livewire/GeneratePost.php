<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Attributes\On;


class GeneratePost extends Component
{
    public $postGenerated = false;
    
    public $generated_post = '';

    public $post_created = false;
    
    public $response = '';

    public $prompt = '';
    public $model = '';
    public $models = [];

    public Post $post;


    // get the Post model instance in the mount
    public function mount(){

    }

    // public function updatedResponse($response){
    //     $this->generated_post = $response;
    // }

    public function render()
    {
        // todo fix copy to clipboard
        // todo disable until click on "generate AI post" and completed the response
        return view('livewire.generate-post');
    }

    #[On('post-created')]
    public function onPostCreated(Post $post)
    {
        $this->post = $post;

        ob_start();
        //        $client = new GuzzleHttp\Client();
        $response = Http::withOptions(['stream' => true])
            ->withHeaders([
                'Content-Type' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'X-Accel-Buffering' => 'no',
                'X-Livewire-Stream' => 'true',
            ])
            ->post('http://localhost:11434/api/generate', [
                'model' => 'llama3.2:3b', // todo make this dynamic
                'prompt' => 'generate very short arabic post for social media from data not html, just plain text', // todo make this dynamic
                'stream' => true
            ]);

        if ($response->getStatusCode() === 200) {
            $body = $response->getBody();
            $buffer = '';
            // Stream the response body as SSE
            while (!$body->eof()) {

                $buffer .= $body->read(1024); // Append chunk to buffer

                // Try to decode JSON from buffer
                while (($pos = strpos($buffer, "\n")) !== false) {
                    $jsonString = substr($buffer, 0, $pos);
                    $buffer = substr($buffer, $pos + 1);

                    $data = json_decode($jsonString, true);

                    if (isset($data['response'])) {
                        $this->response .= $data['response'];

                        $this->stream(
                            to: 'response',
                            content: \Str::markdown($this->response),
                            replace: true
                        );
                    }
                }
            }

            if (!empty($buffer)) {
                $data = json_decode($buffer, true);

                if (isset($data['response'])) {
                    $this->response .= $data['response'];
                    $this->stream(
                        to: 'response',
                        content: \Str::markdown($this->response),
                        replace: true
                    );
                }
            }

            $body->close();

        } else {
            echo "data: Error - HTTP Status Code: ".$response->getStatusCode()."\n\n";
            ob_flush();
            flush();
        }

        $this->generated_post = $this->response;
    }

//     public function mount(){
//         $this->listModels();

// //        if(!$this->models[0]){
// //            die("Be sure to add a model to Ollama before running");
// //            return;
// //        }
// //        $this->model == $this->models[0];

//         $this->model = 'tinyllama:latest';
//     }

    public function modelUpdated(){
        // $this->response = '';
    }

    public function listModels()
    {
        $command = 'ollama list';
        $output = [];
        $returnVar = null;
        exec($command, $output, $returnVar);
        if ($returnVar === 0) {
            $this->models = $output;
        } else {
            $this->models = ['Error: Unable to fetch models'];
        }

        $modelsFiltered = [];

        foreach($this->models as $index => $model){
            if($index != 0){
                $modelParts = explode(':', $model);
                array_push($modelsFiltered, $modelParts[0]);
            }
        }
        $this->models = $modelsFiltered;
    }

    public function submit(){

        $validated = $this->validate([
            'generated_post' => ['required', 'string'],
        ]);

        $this->post->update(['generated_content' => $validated['generated_post']]);  

        return redirect()->route('posts.index');
    }
}
