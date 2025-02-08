<?php

namespace App;

use App\Models\Post;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ollamaPostAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    /**
     * @throws ConnectionException
     */
    public function execute(Post $post): PromiseInterface|\Illuminate\Http\Client\Response
    {
        return Http::withOptions([
            'stream' => true,
        ])
            ->withHeaders([
                'Content-Type' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'X-Accel-Buffering' => 'no',
                'X-Livewire-Stream' => 'true',
            ])
            ->post('http://localhost:11434/api/generate', [
                'model' => 'qwen2.5:0.5b', // todo make this dynamic
                'stream' => true,
                //generate short only arabic post for social media. Use concise, for social media. not HTML. just plain text
                'prompt' => "
                    improve this repo description and make it in Arabic, if there is some technical terms keep them in English
                   -------
                    {$post->repo_description}
                   -------
                    Please provide additional tags for the repository description that added before along with the usual #yemenopensource and #yemen_open_source tags that you always include.
                ",
            ]);
    }
}
