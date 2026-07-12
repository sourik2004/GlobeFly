<x-app-layout>
    <x-slot name="title">GlobeFly Adventures - AI Travel Ecosystem</x-slot>

    <!-- Hero Section -->
    <div class="relative rounded-3xl overflow-hidden mb-16 shadow-2xl border border-slate-800">
        <!-- Background Overlay Image -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1920&q=80'); filter: brightness(0.25) contrast(1.1);"></div>
        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>

        <div class="relative px-8 py-24 md:py-32 md:px-16 text-center max-w-4xl mx-auto z-10 animate-slide-in">
            <span class="inline-block text-xs uppercase tracking-widest text-indigo-400 font-extrabold px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-full mb-6">
                Next-Gen Travel Planning
            </span>
            <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-6">
                Explore the World with <br>
                <span class="text-gradient-purple font-extrabold">Artificial Intelligence</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-300 font-normal max-w-2xl mx-auto mb-10 leading-relaxed">
                Generate personalized day-by-day itineraries, track your budget, reserve hotels and cars, and get real-time assistance from our 24/7 AI chatbot.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('trip.planner') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-brand text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:scale-105 transition duration-250 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Generate AI Itinerary</span>
                </a>
                <a href="{{ route('chat.index') }}" class="w-full sm:w-auto px-8 py-4 bg-slate-900/90 border border-slate-700 text-slate-200 font-bold rounded-xl hover:bg-slate-800 hover:text-white hover:scale-105 transition duration-250 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span>Chat with Travel Bot</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Search / Quick Filters -->
    <div class="mb-16 -mt-8 relative z-20">
        <div class="max-w-4xl mx-auto glass-card p-6 rounded-2xl shadow-xl border border-slate-800">
            <form action="{{ route('tours.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Search Destination</label>
                    <input type="text" name="search" placeholder="e.g., Paris, Japan" class="w-full px-4 py-3 rounded-xl glass-input text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Budget Limits</label>
                    <select name="max_price" class="w-full px-4 py-3 rounded-xl glass-input text-sm">
                        <option value="">Any Budget</option>
                        <option value="25000">Under ₹25,000</option>
                        <option value="50000">Under ₹50,000</option>
                        <option value="75000">Under ₹75,000</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition duration-200 text-sm">
                        Find Travel Matches
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
        <div class="glass-card p-8 rounded-2xl hover-scale">
            <div class="w-12 h-12 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-xl flex items-center justify-center mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Unified Booking Ecosystem</h3>
            <p class="text-slate-400 text-sm leading-relaxed">
                Reserve all your travel amenities inside a single portal. Book organized tour packages, premium rooms, and hire rental cars securely.
            </p>
        </div>

        <div class="glass-card p-8 rounded-2xl hover-scale">
            <div class="w-12 h-12 bg-purple-500/10 border border-purple-500/20 text-purple-400 rounded-xl flex items-center justify-center mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Smart AI Planning</h3>
            <p class="text-slate-400 text-sm leading-relaxed">
                Unlock custom, day-by-day plans built dynamically based on your budget, vacation duration, and special tourist interests.
            </p>
        </div>

        <div class="glass-card p-8 rounded-2xl hover-scale">
            <div class="w-12 h-12 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl flex items-center justify-center mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Financial Cost Analytics</h3>
            <p class="text-slate-400 text-sm leading-relaxed">
                Save plans directly to your profile and track active spending. Group travel expenses by category and compare with budget bounds.
            </p>
        </div>
    </div>

    <!-- Top Seeded Destinations -->
    <div class="mb-20">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-indigo-400 text-xs font-semibold uppercase tracking-wider">Dream Escapes</span>
                <h2 class="text-3xl font-black text-white mt-1">Featured Global Destinations</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($destinations as $dest)
                <a href="{{ route('tours.index') }}?search={{ $dest->name }}" class="group relative h-80 rounded-2xl overflow-hidden block shadow-lg border border-slate-900 hover-scale">
                    <!-- Image -->
                    <img src="{{ $dest->image_url }}" alt="{{ $dest->name }}" class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-110" style="filter: brightness(0.6);">
                    <!-- Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                    <!-- Details -->
                    <div class="absolute bottom-0 inset-x-0 p-6">
                        <span class="text-xs font-mono text-indigo-300 font-semibold uppercase tracking-wider">{{ $dest->location }}</span>
                        <h4 class="text-xl font-bold text-white mb-2">{{ $dest->name }}</h4>
                        <p class="text-slate-300 text-xs line-clamp-2 opacity-0 group-hover:opacity-100 transition duration-300">
                            {{ $dest->description }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Trending Tour Packages -->
    <div class="mb-20">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-indigo-400 text-xs font-semibold uppercase tracking-wider">Curated Experiences</span>
                <h2 class="text-3xl font-black text-white mt-1">Trending Tour Packages</h2>
            </div>
            <a href="{{ route('tours.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm font-semibold flex items-center space-x-1">
                <span>View All Packages</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($packages as $pkg)
                <div class="glass-card rounded-2xl overflow-hidden hover-scale flex flex-col h-full border border-slate-800">
                    <div class="h-48 relative overflow-hidden">
                        <img src="{{ $pkg->image_url }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-4 right-4 bg-slate-950/80 backdrop-blur-md text-xs font-mono font-bold text-indigo-400 px-3 py-1 rounded-full border border-slate-700">
                            {{ $pkg->duration_days }} Days
                        </span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs text-indigo-400 font-mono font-semibold">{{ $pkg->destination->name }}, {{ $pkg->destination->location }}</span>
                            <h3 class="text-xl font-bold text-white mt-1 mb-3">{{ $pkg->name }}</h3>
                            <p class="text-slate-400 text-sm line-clamp-3 mb-6">{{ $pkg->description }}</p>
                        </div>
                        <div class="flex items-center justify-between border-t border-slate-800/80 pt-4">
                            <div>
                                <span class="text-xs text-slate-500 block uppercase">Price per guest</span>
                                <span class="text-2xl font-black text-indigo-400">₹{{ number_format($pkg->price, 0) }}</span>
                            </div>
                            <a href="{{ route('tours.show', $pkg->id) }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition duration-150">
                                Explore Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Verified Partner Hotels -->
    <div class="mb-10">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-indigo-400 text-xs font-semibold uppercase tracking-wider">Premium Stays</span>
                <h2 class="text-3xl font-black text-white mt-1">Verified Partner Hotels</h2>
            </div>
            <a href="{{ route('hotels.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm font-semibold flex items-center space-x-1">
                <span>Browse All Hotels</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($hotels as $htl)
                <div class="glass-card rounded-2xl overflow-hidden hover-scale flex flex-col h-full border border-slate-800">
                    <div class="h-48 relative overflow-hidden">
                        <img src="{{ $htl->image_url }}" alt="{{ $htl->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-amber-500/90 text-slate-950 font-bold px-2 py-0.5 rounded text-xs flex items-center space-x-1 shadow-md">
                            <span>★</span>
                            <span>{{ $htl->star_rating }} Stars</span>
                        </div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs text-indigo-400 font-mono font-semibold">{{ $htl->location }}</span>
                            <h3 class="text-xl font-bold text-white mt-1 mb-3">{{ $htl->name }}</h3>
                            <p class="text-slate-400 text-sm line-clamp-3 mb-6">{{ $htl->description }}</p>
                        </div>
                        <div class="border-t border-slate-800/80 pt-4 flex items-center justify-between">
                            <span class="text-xs text-slate-500">{{ $htl->address }}</span>
                            <a href="{{ route('hotels.show', $htl->id) }}" class="px-4 py-2 bg-indigo-600/10 border border-indigo-500/20 hover:bg-indigo-600 text-indigo-300 hover:text-white text-sm font-bold rounded-xl transition duration-150">
                                View Rooms
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
