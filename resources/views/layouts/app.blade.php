<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'GlobeFly Adventures - AI Travel Assistant')</title>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-100 min-h-screen flex flex-col">
        @include('layouts.navigation')

        <!-- Success/Error Toast Notification -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                 class="fixed bottom-5 right-5 z-50 flex items-center p-4 mb-4 rounded-lg bg-emerald-950/90 border border-emerald-500/30 text-emerald-300 shadow-xl backdrop-blur-md animate-slide-in" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <div class="ms-3 text-sm font-medium pr-8">
                    {{ session('success') }}
                </div>
                <button @click="show = false" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-emerald-400 hover:text-white rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                 class="fixed bottom-5 right-5 z-50 flex items-center p-4 mb-4 rounded-lg bg-red-950/90 border border-red-500/30 text-red-300 shadow-xl backdrop-blur-md animate-slide-in" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
                <div class="ms-3 text-sm font-medium pr-8">
                    {{ session('error') }}
                </div>
                <button @click="show = false" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-red-400 hover:text-white rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Main Page Layout -->
        <div class="flex-grow">
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-slate-900/40 border-b border-slate-900 py-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h1 class="text-3xl font-extrabold text-white leading-tight">
                            {{ $header }}
                        </h1>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-slate-950 border-t border-slate-900/60 pt-20 pb-10 text-slate-350 text-xs mt-auto relative overflow-hidden select-none">
            <!-- Subtle background ambient glows -->
            <div class="absolute -left-10 -bottom-10 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-10 top-0 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Top Multi-Column Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-16 border-b border-slate-900 text-left">
                    <!-- Column 1: Brand Info -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2.5">
                            <span class="text-2xl font-black bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-500 bg-clip-text text-transparent tracking-wide">
                                GlobeFly
                            </span>
                            <span class="text-[9px] px-1.5 py-0.5 bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 rounded font-bold uppercase tracking-wider font-mono">
                                AI v1.5
                            </span>
                        </div>
                        <p class="text-slate-400 text-[11px] leading-relaxed font-normal">
                            Empowering modern explorers with AI-crafted personalized itineraries, premium lodging selections, secure bookings, and real-time smart travel assistance.
                        </p>
                        <!-- Social links -->
                        <div class="flex items-center space-x-2 pt-2">
                            <a href="#" class="flex items-center justify-center w-8 h-8 rounded-lg border border-slate-850 bg-slate-900/40 hover:bg-indigo-650 hover:border-indigo-500 text-slate-400 hover:text-white transition duration-300 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                            </a>
                            <a href="#" class="flex items-center justify-center w-8 h-8 rounded-lg border border-slate-850 bg-slate-900/40 hover:bg-indigo-650 hover:border-indigo-500 text-slate-400 hover:text-white transition duration-300 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.9-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.9 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.08-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.18 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2z"/></svg>
                            </a>
                            <a href="#" class="flex items-center justify-center w-8 h-8 rounded-lg border border-slate-850 bg-slate-900/40 hover:bg-indigo-650 hover:border-indigo-500 text-slate-400 hover:text-white transition duration-300 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Column 2: Discover Links -->
                    <div>
                        <h4 class="text-xs font-bold font-mono uppercase text-white tracking-widest border-b border-slate-850 pb-2 mb-4">
                            Explore Routes
                        </h4>
                        <ul class="space-y-2.5 text-slate-400 font-medium">
                            <li>
                                <a href="{{ route('tours.index') }}" class="hover:text-indigo-400 hover:translate-x-1 duration-200 transform transition-transform inline-block">Tour Packages</a>
                            </li>
                            <li>
                                <a href="{{ route('hotels.index') }}" class="hover:text-indigo-400 hover:translate-x-1 duration-200 transform transition-transform inline-block">Hotel Suites</a>
                            </li>
                            <li>
                                <a href="{{ route('vehicles.index') }}" class="hover:text-indigo-400 hover:translate-x-1 duration-200 transform transition-transform inline-block">Vehicle Rentals</a>
                            </li>
                            <li>
                                <a href="{{ route('trip.planner') }}" class="hover:text-indigo-400 hover:translate-x-1 duration-200 transform transition-transform inline-block">AI Custom Planner</a>
                            </li>
                            <li>
                                <a href="{{ route('chat.index') }}" class="hover:text-indigo-400 hover:translate-x-1 duration-200 transform transition-transform inline-block">24/7 Virtual Assistant</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Column 3: Top Travel Hotspots -->
                    <div>
                        <h4 class="text-xs font-bold font-mono uppercase text-white tracking-widest border-b border-slate-850 pb-2 mb-4">
                            Top Hotspots
                        </h4>
                        <ul class="space-y-2.5 text-slate-400 font-medium">
                            <li>
                                <span class="hover:text-white transition duration-150 cursor-pointer flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                    <span>Taj Mahal (Agra, IN)</span>
                                </span>
                            </li>
                            <li>
                                <span class="hover:text-white transition duration-150 cursor-pointer flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                    <span>Manali Valleys (Himachal, IN)</span>
                                </span>
                            </li>
                            <li>
                                <span class="hover:text-white transition duration-150 cursor-pointer flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-pink-500"></span>
                                    <span>Colosseum (Rome, IT)</span>
                                </span>
                            </li>
                            <li>
                                <span class="hover:text-white transition duration-150 cursor-pointer flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                                    <span>Eiffel Tower (Paris, FR)</span>
                                </span>
                            </li>
                            <li>
                                <span class="hover:text-white transition duration-150 cursor-pointer flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Tower Bridge (London, UK)</span>
                                </span>
                            </li>
                        </ul>
                    </div>

                    <!-- Column 4: Contact & Help -->
                    <div>
                        <h4 class="text-xs font-bold font-mono uppercase text-white tracking-widest border-b border-slate-850 pb-2 mb-4">
                            Contact Support
                        </h4>
                        <ul class="space-y-3.5 text-slate-400 font-medium">
                            <li class="flex items-start space-x-2">
                                <svg class="w-4 h-4 text-indigo-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <span class="text-slate-500 text-[10px] block uppercase font-mono tracking-wider">Email Support</span>
                                    <a href="mailto:support@globefly.com" class="text-slate-200 font-bold hover:text-indigo-400 transition">support@globefly.com</a>
                                </div>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-4 h-4 text-indigo-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <div>
                                    <span class="text-slate-500 text-[10px] block uppercase font-mono tracking-wider">Toll-Free Hotline</span>
                                    <span class="text-slate-200 font-bold">+91 98765 43210</span>
                                </div>
                            </li>
                            <li class="pt-1">
                                <span class="px-2.5 py-1 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 text-[9px] font-bold uppercase tracking-widest inline-block font-mono">
                                    Razorpay Gateway Connected
                                </span>
                            </li>
                        </ul>
                    </div>

                    <!-- Column 5: Newsletter Subscription -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold font-mono uppercase text-white tracking-widest border-b border-slate-850 pb-2 mb-4">
                            Newsletter
                        </h4>
                        <p class="text-slate-400 text-[11px] leading-relaxed">
                            Sign up to receive travel updates, premium hotel deals, and smart expense-tracking guides.
                        </p>
                        <form onsubmit="event.preventDefault(); alert('Subscribed successfully! Welcome to GlobeFly.');" class="space-y-2 pt-1.5">
                            <div class="flex items-center bg-slate-900 border border-slate-800 rounded-xl p-1 focus-within:border-indigo-500/80 transition duration-200">
                                <input type="email" placeholder="Email address" required 
                                       class="flex-grow bg-transparent border-0 focus:ring-0 text-[11px] text-slate-200 placeholder-slate-500 px-3 py-2 outline-none">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold px-4 py-2 rounded-lg transition text-[10px] uppercase tracking-wider">
                                    Join
                                </button>
                            </div>
                            <span class="text-[9px] text-slate-500 block leading-tight">
                                🔒 We value your privacy. Unsubscribe anytime.
                            </span>
                        </form>
                    </div>
                </div>

                <!-- Bottom Footer Section -->
                <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-[11px] text-slate-500 gap-4 font-normal">
                    <p>&copy; {{ date('Y') }} GlobeFly Adventures.All rights reserved.</p>
                    <div class="flex items-center space-x-6">
                        <a href="#" class="hover:text-slate-300 transition">Privacy Policy</a>
                        <a href="#" class="hover:text-slate-300 transition">Terms of Service</a>
                        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="hover:text-white transition flex items-center space-x-1.5 font-medium text-slate-450">
                            <span>Back to top</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
