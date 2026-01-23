<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 space-y-8">
        <h1 class="text-2xl font-bold text-gray-900">{{ __('Find Workers') }}</h1>

        <!-- Search + Filters -->
        <form method="GET" class="bg-white p-4 shadow rounded-lg space-y-4 border border-gray-200">
            <!-- Search box -->
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search...') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 focus:outline-none">
            </div>

            <!-- Filters -->
            <div class="grid gap-4 grid-cols-1 md:grid-cols-5 items-end">
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">{{ __('Job Titles') }}</label>
                    <select id="job_title" name="job_title[]" multiple class="tom-select">
                        @foreach(\App\Models\WorkerProfile::select('job_title')->distinct()->pluck('job_title') as $job)
                            <option value="{{ $job }}" @selected(in_array($job, (array) request('job_title')))>
                                {{ $job }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">{{ __('Skills') }}</label>
                    <select id="skills" name="skill[]" multiple class="tom-select">
                        @foreach(\App\Models\Skill::select('name')->distinct()->pluck('name') as $skill)
                            <option value="{{ $skill }}" @selected(in_array($skill, (array) request('skill')))>
                                {{ $skill }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">{{ __('Services') }}</label>
                    <select id="services" name="service[]" multiple class="tom-select">
                        @foreach(\App\Models\Service::select('name')->distinct()->pluck('name') as $service)
                            <option value="{{ $service }}" @selected(in_array($service, (array) request('service')))>
                                {{ $service }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">{{ __('Portfolios') }}</label>
                    <select id="portfolios" name="portfolio[]" multiple class="tom-select">
                        @foreach(\App\Models\PortfolioItem::select('title')->distinct()->pluck('title') as $portfolio)
                            <option value="{{ $portfolio }}" @selected(in_array($portfolio, (array) request('portfolio')))>
                                {{ $portfolio }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center ml-auto gap-2">
                    <!-- Clear button -->
                    @if(request()->has('search') && request('search') !== '')
                        <a href="{{ route('investor.workers.index') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition duration-200 border border-gray-300">
                            {{ __('Clear') }}
                        </a>
                    @endif

                    <!-- Search button -->
                    <div class="text-right">
                        <button type="submit"
                            class="inline-flex items-center bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-6 py-2.5 font-medium rounded-lg shadow-md hover:shadow-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                            </svg>
                            {{ __('Search') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Search Results -->
        @if(request()->anyFilled(['search', 'job_title', 'skill', 'service', 'portfolio']))
            <div>
                <h2 class="text-xl font-semibold mb-4 text-gray-900">{{ __('Search Results') }}</h2>

                @if($workers->isEmpty())
                    <div class="flex-col items-center content-center h-60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 22a10 10 0 100-20 10 10 0 000 20z" />
                        </svg>
                        <p class="text-gray-500 text-center mt-3">{{ __('No matching workers found.') }}</p>
                    </div>
                @else
                    <div class="grid gap-4 bg-white rounded-lg shadow-md py-3 px-5 border border-gray-200">
                        @foreach($workers as $worker)
                            <div class="flex items-center p-4 hover:bg-emerald-50 rounded-lg transition duration-200">
                                <img src="{{ $worker->avatar ? asset('storage/' . $worker->avatar) : 'https://via.placeholder.com/64' }}"
                                    class="w-16 h-16 rounded-full object-cover border-2 border-emerald-100 shadow-sm mr-4">
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900">{{ $worker->user->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $worker->job_title }}</p>
                                    @if($worker->skills->count() > 0)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($worker->skills->take(3) as $skill)
                                                <span class="text-xs bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full">
                                                    {{ $skill->name }}
                                                </span>
                                            @endforeach
                                            @if($worker->skills->count() > 3)
                                                <span class="text-xs text-gray-500">+{{ $worker->skills->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <!-- View Button -->
                                <a href="{{ route('worker-profiles.show', $worker) }}"
                                    class="inline-flex items-center bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 font-medium rounded-lg shadow-sm hover:shadow transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ __('View') }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $workers->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="flex-col items-center content-center h-60">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                </svg>
                <p class="text-gray-500 text-center mt-3">{{ __('Search for workers using the form above.') }}</p>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            ['#job_title', '#skills', '#services', '#portfolios'].forEach(function (selector) {
                new TomSelect(selector, {
                    plugins: ['remove_button'],
                    create: false,
                    maxItems: null,
                    highlight: true,
                    hidePlaceholder: true,
                    placeholder: "Select options...",
                    render: {
                        option: function(data, escape) {
                            return '<div class="text-gray-700">' + escape(data.value) + '</div>';
                        },
                        item: function(data, escape) {
                            return '<div class="bg-emerald-100 text-emerald-800 border border-emerald-200 rounded px-2 py-1 m-1 text-sm">' + escape(data.value) + '</div>';
                        }
                    }
                });
            });
        });
    </script>
</x-app-layout>
