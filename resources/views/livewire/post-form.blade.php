<div class="mx-auto max-w-lg text-center ">
    <h1 class="text-2xl font-bold sm:text-3xl">Generate Post!</h1>

    <p class="mt-4 text-gray-500">
        Give the necessary details to generate a post.
    </p>


    <form wire:submit="submit" class="mx-auto mt-8 mb-0 max-w-md space-y-4">

        <!-- Yemen Open Source Forked URL -->
        <div>
            <label for="forked_url" class="text-sm font-medium text-gray-700">Yemen Open Source Forked URL <span
                    class="text-red-500">*</span></label>

            <div class="flex gap-2">
                <input
                    wire:model="forkedUrl"
                    id="forked_url"
                    type="url"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://github.com/YemenOpenSource/deepseek-php-client"
                />
                <button
                    wire:click="fetchData"
                    type="button"
                    class="inline-block rounded-lg bg-blue-500 px-3 py-1 text-sm font-medium text-white transition hover:bg-blue-600 focus:ring-3 focus:outline-hidden"
                >
                    Fetch Data 🤌
                </button>
            </div>
        </div>
        <!-- ./Yemen Open Source Forked URL -->

        <!-- Original URL -->
        <div>
            <label for="original_url" class="text-sm font-medium text-gray-700">Original URL <span class="text-red-500">*</span></label>

            <div class="relative">
                <input
                    wire:model="originalUrl"
                    id="original_url"
                    type="url"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://github.com/deepseek-php/deepseek-php-client"
                />
            </div>
        </div>
        <!-- ./Original URL -->

        <!-- repo description -->
        <div>
            <label for="repo_description" class="text-sm font-medium text-gray-700">Repo description <span
                    class="text-red-500">*</span></label>

            <div class="relative">
          <textarea
              wire:model="repoDescription"
              id="repo_description"
              type="url"
              class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
              placeholder="https://github.com/deepseek-php/deepseek-php-client"
              rows="6"
          ></textarea>

            </div>
        </div>
        <!-- ./repo description -->

        <!-- Author name -->
        <div>
            <label for="repo_description" class="text-sm font-medium text-gray-700"> Author name (in Arabic) <span
                    class="text-red-500">*</span></label>

            <div class="relative">
                <input
                    wire:model="authorName"
                    dir="rtl"
                    id="repo_description"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="عمر العلوي"
                />

            </div>
        </div>
        <!-- ./Author name -->

        <!-- GitHub username profile -->
        <div>
            <label for="github_user_profile" class="text-sm font-medium text-gray-700">GitHub username profile</label>

            <div class="relative">
                <input
                    wire:model="githubUserProfile"
                    id="github_user_profile"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://github.com/omaralalwi"
                />
            </div>
        </div>
        <!-- ./GitHub username profile -->

        <!-- LinkedIn profile -->
        <div>
            <label for="linkedin_profile" class="text-sm font-medium text-gray-700">LinkedIn profile</label>

            <div class="relative">
                <input
                    wire:model="linkedinProfile"
                    id="linkedin_profile"
                    type="url"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://www.linkedin.com/in/omaralalwi/"
                />
            </div>
        </div>
        <!-- ./LinkedIn profile -->

        <!-- Author website -->
        <div>
            <label for="author_website" class="text-sm font-medium text-gray-700">Author website</label>

            <div class="relative">
                <input
                    wire:model="authorWebsite"
                    id="author_website"
                    type="url"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="omaralalwi.info"
                />
            </div>
        </div>
        <!-- ./Author website -->

        <!-- Additional links -->
        <div>
            <label for="additional_links" class="text-sm font-medium text-gray-700">Additional links (seperated by new
                lines)</label>

            <div class="relative">
                <textarea
                    wire:model="additionalLinks"
                    id="additional_links"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://github.com/deepseek-php/deepseek-laravel
https://laravel-news.com/deepseek-laravel"
                    rows="3"
                ></textarea>
            </div>
        </div>
        <!-- ./Additional links -->

        <!-- Additional social links -->
        <div>
            <label for="additional_social_links" class="text-sm font-medium text-gray-700">Additional social links
                (seperated by new lines)</label>

            <div class="relative">
                <textarea
                    wire:model="additionalSocialLinks"
                    id="additional_social_links"
                    class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                    placeholder="https://x.com/omaralalwi2013
https://www.facebook.com/omar.alalwi.52"
                    rows="3"
                ></textarea>
            </div>
        </div>
        <!-- ./Additional social links -->

        <div class="flex items-center justify-between">
            <button
                type="submit"
                class="inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-600 focus:ring-3 focus:outline-hidden"
            >
                Generate AI Post  ✨ 👉
            </button>
        </div>
    </form>
</div>
