<div class="mx-auto max-w-lg">
    <h2 class="text-2xl font-bold sm:text-3xl text-center">Generate Post!</h2>

    <p class="mt-4 text-gray-500">
        Give the necessary details to generate a post.
    </p>


    <form wire:submit="submit" class="mx-auto mt-8 mb-0 space-y-4">

        {{-- all errors --}}
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-500">{{ $error }}</li>
            @endforeach
        </ul>
        {{-- all validation errors --}}


        <!-- Yemen Open Source Forked URL -->
        <div>
            <label for="forked_url" class="text-sm font-medium text-gray-700">Yemen Open Source Forked URL </label>

            <div class="flex gap-2">
                <input
                    wire:model="forked_url"
                    id="forked_url"
                    type="url"
                    class="w-4/5 rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs "
                    placeholder="https://github.com/YemenOpenSource/deepseek-php-client"
                />
                <button
                    wire:click="fetchData"
                    type="button"
                    class="w-1/5 relative inline-block rounded-lg bg-blue-500 flex-grow-1 px-3 py-1 text-sm font-medium text-white transition hover:bg-blue-600 focus:ring-3 focus:outline-hidden"
                >
                    <span wire:loading.class="invisible">Fetch Data</span>
                    <span wire:loading.flex
                          class="flex absolute top-0 left-0 justify-center items-center w-full h-full">
{{--                        <svg class="w-3 h-3 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"--}}
                        {{--                             viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"--}}
                        {{--                                                         stroke-width="4"></circle><path class="opacity-75"--}}
                        {{--                                                                                         fill="currentColor"--}}
                        {{--                                                                                         d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>--}}
                        {{--                        </svg>--}}
                        <svg class="w-3 h-3 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24">
  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
  <path class="opacity-75" fill="currentColor"
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>

                    </span>
                </button>

                {{-- <button wire:click="fetchData"  type="button" class=" right-3 top-1/2 px-2 py-1 text-xs tracking-wide bg-black rounded-md transition -translate-y-1/2 cursor-pointer text-neutral-100 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 dark:bg-white dark:text-black dark:focus-visible:outline-white">
                    <span wire:loading.class="invisible">Generate</span>
                    <span wire:loading.flex class="flex absolute top-0 left-0 justify-center items-center w-full h-full">
                        <svg class="w-3 h-3 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </span>
                </button> --}}
            </div>
            <div>
                @error('forked_url') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- ./Yemen Open Source Forked URL -->

        <!-- Original URL -->
        <div>
            <label for="original_url" class="text-sm font-medium text-gray-700">Original URL <span class="text-red-500">*</span></label>

            <div class="relative">
                <input
                    wire:model="original_url"
                    id="original_url"
                    type="url"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://github.com/deepseek-php/deepseek-php-client"
                />
            </div>
            <div>
                @error('original_url') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <!-- ./Original URL -->

        <!-- repo name -->
        <div>
            <label for="repo_name" class="text-sm font-medium text-gray-700">Repo name <span
                    class="text-red-500">*</span></label>

            <div class="relative">

                <input
                    wire:model="repo_name"
                    id="repo_name"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="Deepseek Php Client"
                />

                <div>
                    @error('repo_name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>
        <!-- ./repo name -->

        <!-- repo description -->
        <div>
            <label for="repo_description" class="text-sm font-medium text-gray-700">Repo description (in Arabic)<span
                    class="text-red-500">*</span></label>

            <div class="relative">
          <textarea
              dir="rtl"
              wire:model="repo_description"
              id="repo_description"
              class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
              placeholder="باكج للتكامل مع DeepSeek مع تطبيقات PHP"
              rows="6"
          ></textarea>

                <div>
                    @error('repo_description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>
        <!-- ./repo description -->

        <!-- repo tags -->
        <div>
            <label for="repo_tags_string" class="text-sm font-medium text-gray-700">Repo tags <span
                    class="text-red-500">*</span></label>

            <div class="relative">
          <textarea
              wire:model="repo_tags_string"
              id="repo_tags_string"
              class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
              placeholder="yemen_open_source, larvel, php"
              rows="2"
          ></textarea>

                <div>
                    @error('repo_tags_string') <span class="text-red-500">{{ $message }}</span> @enderror
                    @error('repo_tags') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>
        <!-- ./repo description -->

        <!-- Author name -->
        <div>
            <label for="author_name" class="text-sm font-medium text-gray-700"> Author name (in Arabic) <span
                    class="text-red-500">*</span></label>

            <div class="relative">
                <input
                    wire:model="author_name"
                    dir="rtl"
                    id="author_name"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="عمر العلوي"
                />

                <div>
                    @error('author_name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>

        {{--Yamli start--}}
        {{--        <script type="text/javascript" src="https://api.yamli.com/js/yamli_api.js"></script>--}}
        {{--        <script type="text/javascript">--}}
        {{--            if (typeof (Yamli) == "object" && Yamli.init({uiLanguage: "en", startMode: "onOrUserDefault"})) {--}}
        {{--                Yamli.yamlify("author_name", {settingsPlacement: "inside"});--}}
        {{--            }--}}
        {{--        </script>--}}
        {{--./Yamli end--}}
        <!-- GitHub username profile -->
        <div>
            <label for="github_user_profile" class="text-sm font-medium text-gray-700">GitHub username profile</label>

            <div class="relative">
                <input
                    wire:model="github_user_profile"
                    id="github_user_profile"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://github.com/omaralalwi"
                />
            </div>

            <div>
                @error('github_user_profile') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <!-- ./GitHub username profile -->

        <!-- LinkedIn profile -->
        <div>
            <label for="linkedin_profile" class="text-sm font-medium text-gray-700">LinkedIn profile</label>

            <div class="relative">
                <input
                    wire:model="linkedin_profile"
                    id="linkedin_profile"
                    type="url"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://www.linkedin.com/in/omaralalwi/"
                />
            </div>

            <div>
                @error('linkedin_profile') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <!-- ./LinkedIn profile -->

        <!-- LinkedIn profile -->
        <div>
            <label for="facebook_profile" class="text-sm font-medium text-gray-700">Facebook profile</label>

            <div class="relative">
                <input
                    wire:model="facebook_profile"
                    id="facebook_profile"
                    type="url"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://www.facebook.com/omar.alalwi.52"
                />
            </div>

            <div>
                @error('facebook_profile') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <!-- ./LinkedIn profile -->

        <!-- LinkedIn profile -->
        <div>
            <label for="twitter_profile" class="text-sm font-medium text-gray-700">Twitter profile</label>

            <div class="relative">
                <input
                    wire:model="twitter_profile"
                    id="twitter_profile"
                    type="url"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://x.com/omaralalwi2013"
                />
            </div>

            <div>
                @error('twitter_profile') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <!-- ./LinkedIn profile -->

        <!-- Author website -->
        <div>
            <label for="author_website" class="text-sm font-medium text-gray-700">Author website</label>

            <div class="relative">
                <input
                    wire:model="author_website"
                    id="author_website"
                    type="url"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="omaralalwi.info"
                />
            </div>

            <div>
                @error('author_website') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <!-- ./Author website -->

        <!-- Additional links -->
        <div>
            <label for="additional_links_string" class="text-sm font-medium text-gray-700">Additional links (seperated by new
                lines)</label>

            <div class="relative">
                <textarea
                    wire:model="additional_links_string"
                    id="additional_links_string"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://github.com/deepseek-php/deepseek-laravel
https://laravel-news.com/deepseek-laravel"
                    rows="3"
                ></textarea>


                <div>
                    @error('additional_links') <span class="text-red-500">{{ $message }}</span> @enderror
                    @error('additional_links_string') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <!-- ./Additional links -->

        <div class="flex items-center justify-between" x-data>
            <button
                type="submit"
                class="inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-600 focus:ring-3 focus:outline-hidden"
                @click="scrollTo({top: 0, behavior: 'smooth'})"
            >
                Generate AI Post ✨ 👉
            </button>
        </div>
    </form>
</div>
