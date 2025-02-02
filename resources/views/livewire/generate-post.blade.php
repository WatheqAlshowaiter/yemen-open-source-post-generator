<div class="mx-auto max-w-lg text-center bg:gray-500">
    <h1 class="text-2xl font-bold sm:text-3xl">Generated Post 👇</h1>

    <form wire:submit="submit" class="mx-auto mt-8 mb-0 space-y-4">
        <div>
            <div class="relative">
                <textarea
                    wire:model="generated_post"
                    id="generated_post"
                    class="w-full rounded-lg border-gray-200 border-dashed p-4 pe-12 text-sm shadow-xs"
                    placeholder=""
                    rows="20"
                ></textarea>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <button
                type="submit"
                class="inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-600 focus:ring-3 focus:outline-hidden"
            >
                Save 💾
            </button>

            <button
            type="button"
            class="inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-600 focus:ring-3 focus:outline-hidden"
        >
            Copy to clipboard 📋
        </button>
        </div>
    </form>
</div>
