<nav x-data="{ open: false }" class="bg-slate-950/80 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-500 bg-clip-text text-transparent tracking-wide">
                            GlobeFly
                        </span>
                        <span class="text-xs px-2 py-0.5 bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 rounded-full font-semibold">
                            AI Platform
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 md:flex">
                    <a href="{{ route('home') }}" class="text-sm font-medium transition duration-150 {{ request()->routeIs('home') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                        Home
                    </a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium transition duration-150 {{ request()->routeIs('dashboard') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                            Dashboard
                        </a>

                        @if(auth()->user()->isTraveler())
                            <a href="{{ route('trip.planner') }}" class="text-sm font-medium transition duration-150 {{ request()->routeIs('trip.planner') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                                AI Planner
                            </a>
                            <a href="{{ route('chat.index') }}" class="text-sm font-medium transition duration-150 {{ request()->routeIs('chat.index') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                                AI Chatbot
                            </a>
                        @endif

                        <a href="{{ route('tours.index') }}" class="text-sm font-medium transition duration-150 {{ request()->routeIs('tours.*') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                            Tour Packages
                        </a>
                        <a href="{{ route('hotels.index') }}" class="text-sm font-medium transition duration-150 {{ request()->routeIs('hotels.*') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                            Hotels
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="text-sm font-medium transition duration-150 {{ request()->routeIs('vehicles.index') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                            Car Rentals
                        </a>
                    @else
                        <a href="{{ route('tours.index') }}" class="text-sm font-medium text-slate-300 hover:text-white">Tour Packages</a>
                        <a href="{{ route('hotels.index') }}" class="text-sm font-medium text-slate-300 hover:text-white">Hotels</a>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">
                @auth
                    <div class="flex items-center space-x-4">
                        <!-- Role Badge -->
                        <span class="text-xs px-2 py-0.5 rounded-md border border-slate-700 bg-slate-800 text-slate-300 font-mono capitalize">
                            {{ str_replace('_', ' ', auth()->user()->role) }}
                        </span>

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-slate-800 text-sm leading-4 font-medium rounded-lg text-slate-300 bg-slate-900 hover:text-white hover:bg-slate-800 focus:outline-none transition ease-in-out duration-150">
                                    <span class="w-6 h-6 rounded-full me-2 bg-gradient-to-br from-indigo-500 to-purple-600 text-[10px] font-black text-white flex items-center justify-center border border-indigo-400/30 uppercase font-mono">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')" class="text-slate-300 hover:bg-slate-800 hover:text-white">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();"
                                            class="text-red-400 hover:bg-red-500/10 hover:text-red-300">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="space-x-3">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white px-3 py-2">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-medium bg-gradient-brand text-white px-4 py-2 rounded-lg hover:shadow-lg hover:shadow-indigo-500/20 transition duration-150">
                            Register
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-slate-900 border-b border-slate-800">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">Home</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">Dashboard</a>
                @if(auth()->user()->isTraveler())
                    <a href="{{ route('trip.planner') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">AI Planner</a>
                    <a href="{{ route('chat.index') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">AI Chatbot</a>
                @endif
                <a href="{{ route('tours.index') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">Tour Packages</a>
                <a href="{{ route('hotels.index') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">Hotels</a>
                <a href="{{ route('vehicles.index') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">Car Rentals</a>
            @else
                <a href="{{ route('tours.index') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">Tour Packages</a>
                <a href="{{ route('hotels.index') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">Hotels</a>
                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm font-medium text-indigo-400 hover:bg-slate-800">Register</a>
            @endauth
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-slate-800">
                <div class="px-4">
                    <div class="font-medium text-base text-slate-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">
                        Profile
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="block px-4 py-2 text-sm font-medium text-red-400 hover:bg-red-500/10">
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
