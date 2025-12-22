<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">{{ __('Create Your Profile') }}</h1>

        <form method="POST" action="{{ route('worker-profiles.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Info -->
            <div class="w-full px-6 py-4 bg-white shadow rounded-lg grid gap-6 grid-cols-3">
                <div class="flex flex-col items-center">
                    <label for="avatar" class="font-semibold mb-2">{{ __('Avatar') }}</label>
                    <div class="grid items-center mt-3 h-full">
                        <div class="col-start-1 row-start-1 w-40 h-40 rounded-full object-cover border bg-slate-100"></div>
                        <img id="avatar-preview" class="hidden col-start-1 row-start-1 w-40 h-40 rounded-full object-cover border">
                    </div>
                    <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewPhoto(event, 'avatar-preview')"
                        class="text-xs w-full border mt-3 p-2 rounded-lg shadow bg-blue-50 text-blue-700 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                </div>
                <div class="grid gap-3 col-span-2">
                    <div>
                        <label for="job_title" class="block font-semibold mb-1">{{ __('Job Title') }} <span class="text-red-600">*</span></label>
                        <input type="text" id="job_title" name="job_title" class="w-full border p-2 rounded" required>
                    </div>
                    <div>
                        <label for="bio_title" class="block font-semibold mb-1">{{ __('About Title') }}</label>
                        <input type="text" id="bio_title" name="bio_title" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label for="bio" class="block font-semibold mb-1">{{ __('About Description') }} <span class="text-red-600">*</span></label>
                        <textarea id="bio" name="bio" rows="4" class="w-full border p-2 rounded" required></textarea>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="px-6 py-4 bg-white shadow rounded-lg">
                <h2 class="font-bold mb-3">{{ __('Skills') }}</h2>
                <div id="skills-wrapper" class="space-y-3"></div>
                <button type="button" onclick="addSkill()" class="mt-3 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white px-3 py-1 shadow rounded-lg transition duration-200">
                    + {{ __('Add Skill') }}
                </button>
            </div>

            <!-- Services -->
            <div class="px-6 py-4 bg-white shadow rounded-lg">
                <h2 class="font-bold mb-3">{{ __('Services') }}</h2>
                <div id="services-wrapper" class="space-y-3"></div>
                <button type="button" onclick="addService()" class="mt-3 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white px-3 py-1 shadow rounded-lg transition duration-200">
                    + {{ __('Add Service') }}
                </button>
            </div>

            <!-- Portfolio -->
            <div class="px-6 py-4 bg-white shadow rounded-lg">
                <h2 class="font-bold mb-3">{{ __('Portfolio') }}</h2>
                <div id="portfolio-wrapper" class="space-y-4"></div>
                <button type="button" onclick="addPortfolio()" class="mt-3 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white px-3 py-1 shadow rounded-lg transition duration-200">
                    + {{ __('Add Portfolio Item') }}
                </button>
            </div>

            <!-- Save -->
            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white px-6 py-2 shadow rounded-lg transition duration-200">
                    {{ __('Create') }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewPhoto(event, id) {
            const [file] = event.target.files;

            if (file) {
                const preview = document.getElementById(id);
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        }

        let skillIndex = 0, serviceIndex = 0, portfolioIndex = 0;

        function addSkill() {
            document.getElementById('skills-wrapper').insertAdjacentHTML('beforeend', `
                <div class="p-3 border rounded-lg bg-slate-100 flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <label class="w-28">{{ __('Skill Name') }} <span class="text-red-600">*</span></label>
                        <input type="text" name="skills[${skillIndex}][name]" class="border p-2 rounded flex-1" required>
                    </div>
                    <div class="flex items-start gap-2">
                        <label class="w-28">{{ __('Description') }}</label>
                        <textarea name="skills[${skillIndex}][description]" rows="2" class="border p-2 rounded flex-1"></textarea>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white px-3 py-1 shadow rounded-lg transition duration-200 self-end">
                        {{ __('Delete') }}
                    </button>
                </div>`);
            skillIndex++;
        }

        function addService() {
            document.getElementById('services-wrapper').insertAdjacentHTML('beforeend', `
                <div class="p-3 border rounded-lg bg-slate-100 flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <label class="w-28">{{ __('Service Name') }} <span class="text-red-600">*</span></label>
                        <input type="text" name="services[${serviceIndex}][name]" class="border p-2 rounded flex-1" required>
                    </div>
                    <div class="flex items-start gap-2">
                        <label class="w-28">{{ __('Description') }}</label>
                        <textarea name="services[${serviceIndex}][description]" rows="2" class="border p-2 rounded flex-1"></textarea>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white px-3 py-1 shadow rounded-lg transition duration-200 self-end">
                        {{ __('Delete') }}
                    </button>
                </div>`);
            serviceIndex++;
        }

        function addPortfolio() {
            document.getElementById('portfolio-wrapper').insertAdjacentHTML('beforeend', `
                <div class="p-3 border rounded-lg bg-slate-100 grid gap-6 grid-cols-3">
                    <div class="flex flex-col items-center">
                        <div class="grid items-center mt-3 h-full">
                            <div class="col-start-1 row-start-1 w-32 h-32 rounded-lg bg-slate-200 flex items-center justify-center border"></div>
                            <img id="photo-preview-${portfolioIndex}" class="hidden col-start-1 row-start-1 w-32 h-32 rounded-lg object-cover border">
                        </div>
                        <input type="file" name="portfolio[${portfolioIndex}][image]" accept="image/*" onchange="previewPhoto(event, 'photo-preview-${portfolioIndex}')"
                            class="text-xs w-full border p-2 rounded-lg shadow bg-blue-50 text-blue-700 cursor-pointer mt-3 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    </div>
                    <div class="flex flex-col gap-2 col-span-2">
                        <div class="flex items-center gap-2">
                            <label class="w-28">{{ __('Title') }} <span class="text-red-600">*</span></label>
                            <input type="text" name="portfolio[${portfolioIndex}][title]" class="border p-2 rounded flex-1" required>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="w-28">{{ __('Subtitle') }}</label>
                            <input type="text" name="portfolio[${portfolioIndex}][subtitle]" class="border p-2 rounded flex-1">
                        </div>
                        <div class="flex items-start gap-2">
                            <label class="w-28">{{ __('Description') }}</label>
                            <textarea name="portfolio[${portfolioIndex}][description]" rows="2" class="border p-2 rounded flex-1"></textarea>
                        </div>
                        <button type="button" onclick="this.closest('.p-3').remove()" class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white px-3 py-1 shadow rounded-lg transition duration-200 self-end">
                            {{ __('Delete') }}
                        </button>
                    </div>
                </div>`);
            portfolioIndex++;
        }
    </script>
</x-app-layout>
