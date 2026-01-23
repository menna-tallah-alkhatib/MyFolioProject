<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900">{{ __('Edit Investor Profile') }}</h1>

        <form method="POST" action="{{ route('investor-profiles.update', $investorProfile) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Info -->
            <div class="w-full px-6 py-4 bg-white shadow rounded-lg border border-gray-200 grid gap-6 grid-cols-3">
                <div class="flex flex-col items-center">
                    <label for="avatar" class="font-semibold mb-2 text-gray-700">{{ __('Avatar') }}</label>
                    <div class="grid items-center mt-3 h-full">
                        @if($investorProfile->avatar)
                            <img src="{{ asset('storage/'.$investorProfile->avatar) }}" id="avatar-preview"
                                 class="col-start-1 row-start-1 w-40 h-40 rounded-full object-cover border-2 border-emerald-100 shadow-sm">
                        @else
                            <div id="avatar-placeholder" class="col-start-1 row-start-1 w-40 h-40 rounded-full bg-emerald-50 border-2 border-emerald-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <img id="avatar-preview" class="hidden col-start-1 row-start-1 w-40 h-40 rounded-full object-cover border-2 border-emerald-100 shadow-sm">
                        @endif
                    </div>
                    <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewPhoto(event, 'avatar-preview')"
                           class="w-full mt-3 px-4 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gradient-to-r file:from-emerald-600 file:to-emerald-700 file:text-white hover:file:from-emerald-700 hover:file:to-emerald-800">
                </div>
                <div class="grid gap-3 col-span-2">
                    <div>
                        <label for="job_title" class="block font-semibold mb-1 text-gray-700">{{ __('Job Title') }} <span class="text-red-600">*</span></label>
                        <input type="text" id="job_title" name="job_title" value="{{ old('job_title', $investorProfile->job_title) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 focus:outline-none"
                               required>
                        @error('job_title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="bio" class="block font-semibold mb-1 text-gray-700">{{ __('About Me') }}</label>
                        <textarea id="bio" name="bio" rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 focus:outline-none resize-none">{{ old('bio', $investorProfile->bio) }}</textarea>
                        @error('bio')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Save -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('investor-profiles.show', $investorProfile) }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="inline-flex items-center bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 active:from-emerald-800 active:to-emerald-900 text-white font-medium px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-200">
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
                const placeholder = document.getElementById('avatar-placeholder');
                if (placeholder) placeholder.classList.add('hidden');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>
