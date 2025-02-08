<x-app-layout>

    {{-- list of posts as cards --}}

    <h2>Posts Count: {{$posts->count()}}</h2>

    <div class="mx-auto max-w-screen-xl py-8">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-1 lg:gap-4">
            @foreach ($posts as $post)
            {{-- make it clickable to go to post edit page --}}
            <a href="{{route('posts.edit', $post->id)}}">
                <div class=" rounded-lg border-2 border-indigo-400 border-dashed py-4 px-4">
                    <p class="text-gray-500">
                       #{{$post->id}} {{$post->original_url}} - {{$post->repo_name}} - {{$post->author_name}}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
