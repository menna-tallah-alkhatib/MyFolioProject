<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900">{{ __('Edit Profile') }}</h1>

        <form method="POST" action="{{ route('worker-profiles.update', $workerProfile) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Info -->
            <div class="w-full px-6 py-4 bg-white shadow rounded-lg border border-gray-200 grid gap-6 grid-cols-3">
                <input type="hidden" name="id" value="{{ $workerProfile->id }}">
                <div class="flex flex-col items-center">
                    <label for="avatar" class="font-semibold mb-2 text-gray-700">{{ __('Avatar') }}</label>
                    <div class="grid items-center mt-3 h-full">
                        @if($workerProfile->avatar)
                            <img src="{{ asset('storage/'.$workerProfile->avatar) }}" id="avatar-preview"
                                 class="col-start-1 row-start-1 w-40 h-40 rounded-full object-cover border-2 border-emerald-100 shadow-sm">
                        @else
                            <div id="avatar-placeholder" class="col-start-1 row-start-1 w-40 h-40 rounded-full   border-2 border-emerald-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <img id="avatar-preview" class="hidden col-start-1 row-start-1 w-40 h-40 rounded-full object-cover border-2 border-emerald-100 shadow-sm">
                        @endif
                    </div>
                    <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewPhoto(event, 'avatar-preview')"
                           class="w-full mt-3 px-4 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
                </div>
                <div class="grid gap-3 col-span-2">
                    <div>
                        <label for="job_title" class="block font-semibold mb-1 text-gray-700">{{ __('Job Title') }} <span class="text-red-600">*</span></label>
                        <input type="text" id="job_title" name="job_title" value="{{ old('job_title', $workerProfile->job_title) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 focus:outline-none"
                               required>
                        @error('job_title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="bio_title" class="block font-semibold mb-1 text-gray-700">{{ __('About Title') }}</label>
                        <input type="text" id="bio_title" name="bio_title" value="{{ old('bio_title', $workerProfile->bio_title) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 focus:outline-none">
                    </div>
                    <div>
                        <label for="bio" class="block font-semibold mb-1 text-gray-700">{{ __('About Description') }} <span class="text-red-600">*</span></label>
                        <textarea id="bio" name="bio" rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 focus:outline-none resize-none"
                                  required>{{ old('bio', $workerProfile->bio) }}</textarea>
                        @error('bio')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="px-6 py-4 bg-white shadow rounded-lg border border-gray-200">
                <h2 class="font-bold mb-3 text-gray-900">{{ __('Skills') }}</h2>
                <div id="skills-wrapper" class="space-y-3">
                    @foreach($workerProfile->skills as $i => $skill)
                        <div class="p-3 border border-gray-300 rounded-lg   flex flex-col gap-2">
                            <input type="hidden" name="skills[{{ $i }}][id]" value="{{ $skill->id }}">
                            <div class="flex items-center gap-2">
                                <label class="w-28 text-gray-700">{{ __('Skill Name') }} <span class="text-red-600">*</span></label>
                                <input type="text" name="skills[{{ $i }}][name]" value="{{ $skill->name }}"
                                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1"
                                       required>
                            </div>
                            <div class="flex items-start gap-2">
                                <label class="w-28 text-gray-700">{{ __('Description') }}</label>
                                <textarea name="skills[{{ $i }}][description]" rows="2"
                                          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1">{{ $skill->description }}</textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()"
                                    class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition duration-200 self-end text-sm font-medium">
                                {{ __('Delete') }}
                            </button>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addSkill()"
                        class="mt-3 inline-flex items-center bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white px-4 py-2 rounded-lg shadow-sm hover:shadow transition duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Add Skill') }}
                </button>
            </div>

            <!-- Services -->
            <div class="px-6 py-4 bg-white shadow rounded-lg border border-gray-200">
                <h2 class="font-bold mb-3 text-gray-900">{{ __('Services') }}</h2>
                <div id="services-wrapper" class="space-y-3">
                    @foreach($workerProfile->services as $i => $service)
                        <div class="p-3 border border-gray-300 rounded-lg   flex flex-col gap-2">
                            <input type="hidden" name="services[{{ $i }}][id]" value="{{ $service->id }}">
                            <div class="flex items-center gap-2">
                                <label class="w-28 text-gray-700">{{ __('Service Name') }} <span class="text-red-600">*</span></label>
                                <input type="text" name="services[{{ $i }}][name]" value="{{ $service->name }}"
                                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1"
                                       required>
                            </div>
                            <div class="flex items-start gap-2">
                                <label class="w-28 text-gray-700">{{ __('Description') }}</label>
                                <textarea name="services[{{ $i }}][description]" rows="2"
                                          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1">{{ $service->description }}</textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()"
                                    class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition duration-200 self-end text-sm font-medium">
                                {{ __('Delete') }}
                            </button>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addService()"
                        class="mt-3 inline-flex items-center bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white px-4 py-2 rounded-lg shadow-sm hover:shadow transition duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Add Service') }}
                </button>
            </div>

            <!-- Portfolio -->
            <div class="px-6 py-4 bg-white shadow rounded-lg border border-gray-200">
                <h2 class="font-bold mb-3 text-gray-900">{{ __('Portfolio') }}</h2>
                <div id="portfolio-wrapper" class="space-y-4">
                    @foreach($workerProfile->portfolioItems as $i => $item)
                        <div class="p-3 border border-gray-300 rounded-lg   grid gap-6 grid-cols-3">
                            <input type="hidden" name="portfolio[{{ $i }}][id]" value="{{ $item->id }}">
                            <div class="flex flex-col items-center">
                                <div class="grid items-center mt-3 h-full">
                                    @if($item->image)
                                        <img src="{{ asset('storage/'.$item->image) }}" id="photo-preview-{{ $i }}" class="col-start-1 row-start-1 w-32 h-32 rounded-lg object-cover border-2 border-emerald-100 shadow-sm">
                                    @else
                                        <div class="col-start-1 row-start-1 w-32 h-32 rounded-lg bg-emerald-100 border-2 border-emerald-200 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <img id="photo-preview-{{ $i }}" class="hidden col-start-1 row-start-1 w-32 h-32 rounded-lg object-cover border-2 border-emerald-100 shadow-sm">
                                    @endif
                                </div>
                                <input type="file" name="portfolio[{{ $i }}][image]" accept="image/*" onchange="previewPhoto(event, 'photo-preview-{{ $i }}')"
                                       class="w-full mt-3 px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
                            </div>
                            <div class="flex flex-col gap-2 col-span-2">
                                <div class="flex items-center gap-2">
                                    <label class="w-28 text-gray-700">{{ __('Title') }} <span class="text-red-600">*</span></label>
                                    <input type="text" name="portfolio[{{ $i }}][title]" value="{{ $item->title }}"
                                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1"
                                           required>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="w-28 text-gray-700">{{ __('Subtitle') }}</label>
                                    <input type="text" name="portfolio[{{ $i }}][subtitle]" value="{{ $item->subtitle }}"
                                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1">
                                </div>
                                <div class="flex items-start gap-2">
                                    <label class="w-28 text-gray-700">{{ __('Description') }}</label>
                                    <textarea name="portfolio[{{ $i }}][description]" rows="2"
                                              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1">{{ $item->description }}</textarea>
                                </div>
                                <button type="button" onclick="this.closest('.p-3').remove()"
                                        class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition duration-200 self-end text-sm font-medium">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addPortfolio()"
                        class="mt-3 inline-flex items-center bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white px-4 py-2 rounded-lg shadow-sm hover:shadow transition duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Add Portfolio Item') }}
                </button>
            </div>

            <!-- Save -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('worker-profiles.show', $workerProfile) }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-medium px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewPhoto(event, id) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById(id);
                const placeholder = preview.previousElementSibling;
                if (placeholder && placeholder.classList.contains('bg-emerald-100')) {
                    placeholder.classList.add('hidden');
                }
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        }

        let skillIndex = {{ $workerProfile->skills->count() }};
        let serviceIndex = {{ $workerProfile->services->count() }};
        let portfolioIndex = {{ $workerProfile->portfolioItems->count() }};

        function addSkill() {
            document.getElementById('skills-wrapper').insertAdjacentHTML('beforeend', `
                <div class="p-3 border border-gray-300 rounded-lg   flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <label class="w-28 text-gray-700">{{ __('Skill Name') }} <span class="text-red-600">*</span></label>
                        <input type="text" name="skills[${skillIndex}][name]"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1"
                               required>
                    </div>
                    <div class="flex items-start gap-2">
                        <label class="w-28 text-gray-700">{{ __('Description') }}</label>
                        <textarea name="skills[${skillIndex}][description]" rows="2"
                                  class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1"></textarea>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()"
                            class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition duration-200 self-end text-sm font-medium">
                        {{ __('Delete') }}
                    </button>
                </div>`);
            skillIndex++;
        }

        function addService() {
            document.getElementById('services-wrapper').insertAdjacentHTML('beforeend', `
                <div class="p-3 border border-gray-300 rounded-lg   flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <label class="w-28 text-gray-700">{{ __('Service Name') }} <span class="text-red-600">*</span></label>
                        <input type="text" name="services[${serviceIndex}][name]"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1"
                               required>
                    </div>
                    <div class="flex items-start gap-2">
                        <label class="w-28 text-gray-700">{{ __('Description') }}</label>
                        <textarea name="services[${serviceIndex}][description]" rows="2"
                                  class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1"></textarea>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()"
                            class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition duration-200 self-end text-sm font-medium">
                        {{ __('Delete') }}
                    </button>
                </div>`);
            serviceIndex++;
        }

        function addPortfolio() {
            document.getElementById('portfolio-wrapper').insertAdjacentHTML('beforeend', `
                <div class="p-3 border border-gray-300 rounded-lg   grid gap-6 grid-cols-3">
                    <div class="flex flex-col items-center">
                        <div class="grid items-center mt-3 h-full">
                            <div class="col-start-1 row-start-1 w-32 h-32 rounded-lg bg-emerald-100 border-2 border-emerald-200 flex items-center justify-center">
                                <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <img id="photo-preview-${portfolioIndex}" class="hidden col-start-1 row-start-1 w-32 h-32 rounded-lg object-cover border-2 border-emerald-100 shadow-sm">
                        </div>
                        <input type="file" name="portfolio[${portfolioIndex}][image]" accept="image/*" onchange="previewPhoto(event, 'photo-preview-${portfolioIndex}')"
                               class="w-full mt-3 px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
                    </div>
                    <div class="flex flex-col gap-2 col-span-2">
                        <div class="flex items-center gap-2">
                            <label class="w-28 text-gray-700">{{ __('Title') }} <span class="text-red-600">*</span></label>
                            <input type="text" name="portfolio[${portfolioIndex}][title]"
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1"
                                   required>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="w-28 text-gray-700">{{ __('Subtitle') }}</label>
                            <input type="text" name="portfolio[${portfolioIndex}][subtitle]"
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1">
                        </div>
                        <div class="flex items-start gap-2">
                            <label class="w-28 text-gray-700">{{ __('Description') }}</label>
                            <textarea name="portfolio[${portfolioIndex}][description]" rows="2"
                                      class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 flex-1"></textarea>
                        </div>
                        <button type="button" onclick="this.closest('.p-3').remove()"
                                class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition duration-200 self-end text-sm font-medium">
                            {{ __('Delete') }}
                        </button>
                    </div>
                </div>`);
            portfolioIndex++;
        }
    </script>
</x-app-layout>
