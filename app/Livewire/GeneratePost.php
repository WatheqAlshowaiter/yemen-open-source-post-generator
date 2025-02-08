<?php

namespace App\Livewire;

use App\Models\Post;
use App\ollamaPostAction;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;



class GeneratePost extends Component
{
    public $postGenerated = false;

    public $generated_post = '';
    public $generated_tweet= '';

    public $post_created = false;

    public $response = '';

    public $prompt = '';
    public $model = '';
    public $models = [];

    public Post $post;

    public array $introductions = [];

    // get the Post model instance in the mount
    public function mount()
    {
        if(Session::has('redirectedPost')){

            $sessionValue = Session::pull('redirectedPost');

            $this->onPostCreated(
                Post::findOrfail($sessionValue)
            );
        }

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

    /**
     * @throws ConnectionException
     */
    #[On('post-created')]
    public function onPostCreated(Post $post)
    {
        // تبقى تضبيط شيئين
        // وصف المشروع
        // ال tags
        //        give me 3-5 tags from this text, inline them and make them snake_case, add them to #yemen_open_source and #yemenopensource. return only the tags, not more text needed.
        //⚡️ supercharged community-maintained PHP API client that allows you to interact with deepseek API


        $this->post = $post;

        $this->response = '';
        $this->generated_post = '';


        $introductions = [
            "عدنا لكم هذه المرة مع المبدع {$this->post->author_name}!",
            "مرحباً بكم مجدداً! يعود إلينا {$this->post->author_name} بإبداع جديد في عالم البرمجة مفتوحة المصدر.",
            "مشروع جديد من المبدع {$this->post->author_name}!",
            "نرحب بالمبرمج {$this->post->author_name} الذي يقدم لنا مشروعاً جديداً ومميزاً!",
            "مرحباً مجدداً! يقدم لنا {$this->post->author_name} مشروعاً جديداً يستحق المتابعة.",
            "عودتنا مع المبدع {$this->post->author_name} وابتكار جديد في البرمجة مفتوحة المصدر!",
            "مشروع جديد من المبدع {$this->post->author_name}! انضموا إلينا لاكتشاف المزيد.",
            "نعود إليكم مع {$this->post->author_name} الذي قدم لنا إبداعاً جديداً في مجال البرمجيات مفتوحة المصدر.",
            "عدنا لكم هذه المرة مع المبرمج {$this->post->author_name} الذي يقدم لنا مشروعه الجديد.",
            "مشروع جديد من {$this->post->author_name} المبدع الذي يضيف الكثير لمجتمع البرمجيات مفتوحة المصدر."
        ];


        $introducingProjects = [
            "ومشروعه هو \"{$post->repo_name}\"",
            "والمشروع هو \"{$post->repo_name}\"",
            "اسم المشروع \"{$post->repo_name}\""
        ];

        // random from $introduction array

        $this->generated_post = $introductions[array_rand($introductions)]."\n\n";
        $this->generated_post .= $introducingProjects[array_rand($introducingProjects)]."\n\n";

        //$this->generated_post .= $this->response . "\n\n";

        $this->generated_post .= "وصف المشروع\n";
        $this->generated_post .= trim($post->repo_description) . "\n\n";

        $this->generated_post .= implode(' ', $this->arrayToHashtags(array_merge($post->repo_tags, ['yemen_open_source', 'yemenopensource']) ?? [])) ."\n\n";


        //dd($this->generated_post);

        $this->generated_post .= "الروابط:\n";

        $this->generated_post .= "رابط المشروع\n";
        $this->generated_post .= $this->post->original_url."\n\n";


        if ($this->post->forked_url) {
            $this->generated_post .= "رابط المشروع على YemenOpenSource\n";
            $this->generated_post .= $this->post->forked_url."\n\n";
        }

        $this->generated_post .= "حساب ".$this->post->author_name." على GitHub\n";
        $this->generated_post .= $this->post->github_user_profile."\n\n";

        if ($this->post->linkedin_profile) {
            $this->generated_post .= "على لينكدن\n";
            $this->generated_post .= $this->post->linkedin_profile."\n\n";
        }

        if ($this->post->twitter_profile) {
            $this->generated_post .= "تويتر (إكس)\n";
            $this->generated_post .= $this->post->twitter_profile."\n\n";
        }

        if ($this->post->facebook_profile) {
            $this->generated_post .= "فيس بوك\n";
            $this->generated_post .= $this->post->facebook_profile."\n\n";
        }

        if ($this->post->author_website) {
            $this->generated_post .= "الموقع الشخصي\n";
            $this->generated_post .= $this->post->author_website."\n\n";
        }

        if (count($this->post->additional_links) > 0) {
            $this->generated_post .= "روابط أخرى\n";
            $this->generated_post .= implode("\n", $this->post->additional_links);
        }

        $this->generated_post .= "\n\nوندعوكم في المساهمة في مشاريعنا مفتوحة المصدر سواء بالتطوير البرمجي أو الترويج لها في مختلف منصات مواقع التواصل الاجتماعي..
ولا تنسوا متابعة صفحاتنا على مواقع التواصل الاجتماعي كي لا تفوتكم أي مشاريع جديدة ومفيدة..";

        $this->generateTeet();


    }

    public function generateTeet(){


        // make it very short 
        $introductions = [
            "نرحب بالمبدع {$this->post->author_name}!",
            "مرحبا بالمبدع {$this->post->author_name}!",
            "أهلا بمشروع جديد من المبدع {$this->post->author_name}!",
        ];


        $introducingProjects = [
            "المشروع \"{$this->post->repo_name}\"",
            "اسم المشروع \"{$this->post->repo_name}\""
        ];

        $this->generated_tweet = $introductions[array_rand($introductions)]."\n\n";
        $this->generated_tweet .= $introducingProjects[array_rand($introducingProjects)]."\n\n";


//         $this->generated_post .= "وصف المشروع\n";
        $this->generated_tweet .= trim($this->post->repo_description) . "\n\n";
        

        $this->generated_tweet .= implode(' ', $this->arrayToHashtags(array_merge($this->post->repo_tags, ['yemen_open_source', 'yemenopensource']) ?? [])) ."\n\n";


//         //dd($this->generated_post);

//         $this->generated_post .= "الروابط:\n";

        $this->generated_tweet .= "رابط المشروع\n";
        $this->generated_tweet .= $this->post->original_url."\n\n";


        // if ($this->post->forked_url) {
        //     $this->generated_tweet .= "رابط المشروع على YemenOpenSource\n";
        //     $this->generated_tweet .= $this->post->forked_url."\n\n";
        // }

        // $this->generated_tweet .= "حساب ".$this->post->author_name." على GitHub\n";
        // $this->generated_tweet .= $this->post->github_user_profile."\n\n";

        // if ($this->post->linkedin_profile) {
        //     $this->generated_tweet .= "على لينكدن\n";
        //     $this->generated_tweet .= $this->post->linkedin_profile."\n\n";
        // }

        if ($this->post->twitter_profile) {
            $twitterHandle =   ltrim(parse_url($this->post->twitter_profile, PHP_URL_PATH), '/');

            $this->generated_tweet .= '@' . $twitterHandle;
        }

        // if ($this->post->facebook_profile) {
        //     $this->generated_tweet .= "فيس بوك\n";
        //     $this->generated_tweet .= $this->post->facebook_profile."\n\n";
        // }

        // if ($this->post->author_website) {
        //     $this->generated_tweet .= "الموقع الشخصي\n";
        //     $this->generated_tweet .= $this->post->author_website."\n\n";
        // }

        // if (count($this->post->additional_links) > 0) {
        //     $this->generated_tweet .= "روابط أخرى\n";
        //     $this->generated_tweet .= implode("\n", $this->post->additional_links);
        // }

//         $this->generated_post .= "\n\nوندعوكم في المساهمة في مشاريعنا مفتوحة المصدر سواء بالتطوير البرمجي أو الترويج لها في مختلف منصات مواقع التواصل الاجتماعي..
// ولا تنسوا متابعة صفحاتنا على مواقع التواصل الاجتماعي كي لا تفوتكم أي مشاريع جديدة ومفيدة..";


    }

    public function modelUpdated()
    {
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

        foreach ($this->models as $index => $model) {
            if ($index != 0) {
                $modelParts = explode(':', $model);
                array_push($modelsFiltered, $modelParts[0]);
            }
        }
        $this->models = $modelsFiltered;
    }

    public function submit()
    {
        $validated = $this->validate([
            'generated_post' => ['required', 'string'],
            'generated_tweet' => ['required', 'string'],
        ]);

        $this->post->update([
            'generated_content' => $validated['generated_post'], 
            'generated_tweet' => $validated['generated_tweet'],
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * @param  Post  $post
     *
     * @return void
     * @throws ConnectionException
     */
    private function ollamaResponse(Post $post): void
    {
        ob_start();

        $ollamaPostAction = app(OllamaPostAction::class);

        $response = $ollamaPostAction->execute($post);

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
    }

    private function arrayToHashtags($array)
    {
        return array_map(function ($item) {
            // Sanitize each item (remove spaces and special characters)
            $item = preg_replace('/[^a-zA-Z0-9]/', '', $item);

            // Add the hash symbol before each item
            return '#'. \Str::snake($item); // Capitalize the first letter of each hashtag
        }, $array);
    }
}
