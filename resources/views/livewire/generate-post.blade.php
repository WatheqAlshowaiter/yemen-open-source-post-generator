<div class="mx-auto max-w-lg text-center bg:gray-500" >
    <h1 class="text-2xl font-bold sm:text-3xl">Generated Post 👇</h1>

    <form wire:submit="submit" class="mx-auto mt-8 mb-0 space-y-4">
        <div class="flex flex-col flex-1 justify-between items-center pt-5 pb-4 mx-auto w-full h-full" >
            <div class="relative p-5 w-full h-auto rounded-lg border border-zinc-200 bg-zinc-50 prose prose-md">
                <textarea
                    dir="rtl"
                    wire:model="generated_post"
                    id="generated_post"
                    class="w-full rounded-lg border-gray-200 border-dashed p-4 pe-12 text-sm shadow-xs"
                    placeholder=""
                    rows="20"
                >{!! $response !!}</textarea>
            </div>
        </div>


        <div>
            @error('generated_post') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between">
            {{-- this should be disables until post_created = true, use alpine.js to disable the button --}}

            <button
                type="submit"
                class="inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-600 focus:ring-3 focus:outline-hidden"
            >
                Save 💾
            </button>

            {{-- Alpine.js for Copy to Clipboard --}}
            <div x-data="{
                copyText: @entangle('generated_post'),
                copyNotification: false,
                copyToClipboard() {
                    navigator.clipboard.writeText(this.copyText);
                    this.copyNotification = true;
                    let that = this;
                    setTimeout(function(){
                        that.copyNotification = false;
                    }, 3000);
                }
            }" class="relative z-20 flex items-center">
                <button type="button" @click="copyToClipboard();" class="flex items-center justify-center w-auto h-8 px-3 py-1 text-xs bg-white border rounded-md cursor-pointer border-neutral-200/60 hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none text-neutral-500 hover:text-neutral-600 group">
                    <span x-show="!copyNotification" x-cloak>Copy to Clipboard</span>
                    <svg x-show="!copyNotification" class="w-4 h-4 ml-1.5 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    <span x-show="copyNotification" class="tracking-tight text-green-500" x-cloak>Copied to Clipboard</span>
                    <svg x-show="copyNotification" class="w-4 h-4 ml-1.5 text-green-500 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                    </svg>
                </button>
            </div>
        </div>


        {{-- <button wire:click="onPostCreated(3)" type="button" class="relative inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-600 focus:ring-3 focus:outline-hidden">
            <span wire:loading.class="invisible">Generate TEMP</span>
            <span wire:loading.flex class="flex absolute top-0 left-0 justify-center items-center w-full h-full">
               <svg class="w-3 h-3 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
            </span>
        </button> --}}
    </form>
</div>
