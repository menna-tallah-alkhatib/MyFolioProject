<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-gradient-to-r from-emerald-600 to-emerald-700 backdrop-blur border-b border-emerald-800 shadow-lg">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ url('/') }}">
                        <b  class="text-xl  block h-9 w-auto fill-current"><span style="color: #151616">My</span>Folio</b>
                        {{-- <x-application-logo class="block h-9 w-auto fill-current text-white" /> --}}
                    </a>

                    @hasrole('admin')
                    <span class="bg-white/20 backdrop-blur-sm rounded-md mr-1.5 text-white px-2 py-0.5 uppercase font-bold text-xs border border-white/30">
                        {{ __('Admin') }}
                    </span>
                    @endhasrole
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @hasrole('investor')
                    <x-nav-link :href="route('investor.workers.index')"
                        :active="request()->routeIs('investor.workers.index')">
                        {{ __('Search Workers') }}
                    </x-nav-link>

                    <x-nav-link :href="Auth::user()->investorProfile ? route('investor-profiles.show', Auth::user()->investorProfile) : route('investor-profiles.create')"
                        :active="request()->routeIs('investor-profiles.*')">
                        {{ __('Investor Profile') }}
                    </x-nav-link>
                    @endhasrole

                    @hasrole('worker')
                    <x-nav-link :href="Auth::user()->workerProfile ? route('worker-profiles.show', Auth::user()->workerProfile) : route('worker-profiles.create')"
                        :active="request()->routeIs('worker-profiles.*')">
                        {{ __('Worker Profile') }}
                    </x-nav-link>
                    @endhasrole

                    <!-- Admin Control Panel -->
                    @hasrole('admin')
                    <x-nav-link :href="route('admin.dashboard')"
                        :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.users.index')"
                        :active="request()->routeIs('admin.users.*')">
                        {{ __('Users') }}
                    </x-nav-link>

                    <x-nav-link :href="route('worker-profiles.index')"
                        :active="request()->routeIs('worker-profiles.*')">
                        {{ __('Worker Profiles') }}
                    </x-nav-link>

                    <x-nav-link :href="route('investor-profiles.index')"
                        :active="request()->routeIs('investor-profiles.*')">
                        {{ __('Investor Profiles') }}
                    </x-nav-link>
                    @endhasrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Messages -->
                <x-nav-link :href="route('conversations.index')" :active="request()->routeIs('conversations.*')"
                    title="{{ __('Conversations') }}"
                    class="relative flex items-center h-full px-3 text-white/90 hover:text-white mr-4">
                    <!-- Chat Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                    </svg>
                    <!-- Counter -->
                    @if($unreadMessagesCount > 0)
                        <span
                            class="absolute -top-1 -right-1 bg-white text-emerald-700 text-xs font-bold h-5 w-5 flex items-center justify-center rounded-full border border-emerald-800 shadow-sm">
                            {{ $unreadMessagesCount }}
                        </span>
                    @endif
                </x-nav-link>

                <div class="flex items-center gap-2">
                    <!-- Avatar -->
                    @php
                        $user = Auth::user();
                        $avatar = null;

                        // Worker avatar
                        if ($user->hasRole('worker') && $user->workerProfile?->avatar) {
                            $avatar = asset('storage/' . $user->workerProfile->avatar);
                        }

                        // Investor avatar
                        if ($user->hasRole('investor') && $user->investorProfile?->avatar) {
                            $avatar = asset('storage/' . $user->investorProfile->avatar);
                        }
                    @endphp

                    @if($avatar)
                        <img src="{{ $avatar }}" alt="avatar" class="w-8 h-8 rounded-full object-cover border-2 border-white/80 shadow-sm">
                    @else
                        <div
                            class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-semibold text-sm border border-white/40">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-white hover:bg-white/10 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/10 focus:outline-none focus:bg-white/10 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-emerald-700 border-t border-emerald-800">
        <div class="pt-2 pb-3 space-y-1">
            @hasrole('investor')
            <x-responsive-nav-link :href="route('investor.workers.index')"
                :active="request()->routeIs('investor.workers.index')">
                {{ __('Search Workers') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="Auth::user()->investorProfile ? route('investor-profiles.show', Auth::user()->investorProfile) : route('investor-profiles.create')"
                :active="request()->routeIs('investor-profiles.*')">
                {{ __('Investor Profile') }}
            </x-responsive-nav-link>
            @endhasrole

            @hasrole('worker')
            <x-responsive-nav-link :href="Auth::user()->workerProfile ? route('worker-profiles.show', Auth::user()->workerProfile) : route('worker-profiles.create')"
                :active="request()->routeIs('worker-profiles.*')">
                {{ __('Worker Profile') }}
            </x-responsive-nav-link>
            @endhasrole

            <!-- Admin Control Panel -->
            @hasrole('admin')
            <x-responsive-nav-link :href="route('admin.dashboard')"
                :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.users.index')"
                :active="request()->routeIs('admin.users.*')">
                {{ __('Users') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('worker-profiles.index')"
                :active="request()->routeIs('worker-profiles.*')">
                {{ __('Worker Profiles') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('investor-profiles.index')"
                :active="request()->routeIs('investor-profiles.*')">
                {{ __('Investor Profiles') }}
            </x-responsive-nav-link>
            @endhasrole

            <!-- Messages -->
            <x-responsive-nav-link :href="route('conversations.index')" :active="request()->routeIs('conversations.*')">
                <div class="flex items-center justify-between">
                    <span>{{ __('Messages') }}</span>
                    @if($unreadMessagesCount > 0)
                        <span class="bg-white text-emerald-700 text-xs font-bold px-2 py-1 rounded-full">
                            {{ $unreadMessagesCount }}
                        </span>
                    @endif
                </div>
            </x-responsive-nav-link>
        </div>


        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-emerald-800">
            <div class="flex items-center gap-3 px-4">
                <div class="flex items-center gap-2">
                    <!-- Avatar -->
                    @php
                        $user = Auth::user();
                        $avatar = null;

                        // Worker avatar
                        if ($user->hasRole('worker') && $user->workerProfile?->avatar) {
                            $avatar = asset('storage/' . $user->workerProfile->avatar);
                        }

                        // Investor avatar
                        if ($user->hasRole('investor') && $user->investorProfile?->avatar) {
                            $avatar = asset('storage/' . $user->investorProfile->avatar);
                        }
                    @endphp

                    @if($avatar)
                        <img src="{{ $avatar }}" alt="avatar" class="w-10 h-10 rounded-full object-cover border-2 border-white/80">
                    @else
                        <div
                            class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-semibold text-base border border-white/40">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white/80">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
