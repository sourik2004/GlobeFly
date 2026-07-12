<x-app-layout>
    <x-slot name="header">
        Find Verified Accommodations
    </x-slot>

    <!-- Search Filters -->
    <div class="glass-card p-6 rounded-2xl mb-10 shadow-lg border border-slate-800">
        <form action="{{ route('hotels.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Search Hotel / City</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="e.g. Kyoto Ryokan, Paris..." class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Star Rating (Min)</label>
                <select name="stars" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
                    <option value="">Any Rating</option>
                    <option value="3" {{ request('stars') == 3 ? 'selected' : '' }}>3+ Stars</option>
                    <option value="4" {{ request('stars') == 4 ? 'selected' : '' }}>4+ Stars</option>
                    <option value="5" {{ request('stars') == 5 ? 'selected' : '' }}>5 Stars Only</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-sm transition">
                    Search Hotels
                </button>
            </div>
        </form>
    </div>

    <!-- Hotel Grid -->
    @if($hotels->isEmpty())
        <div class="text-center py-20 glass-card rounded-3xl">
            <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <h3 class="text-xl font-bold text-white mb-2">No hotels found</h3>
            <p class="text-slate-400 text-sm">Try using different search keywords or resetting rating levels.</p>
            <a href="{{ route('hotels.index') }}" class="inline-block mt-4 px-4 py-2 bg-slate-900 border border-slate-800 text-indigo-400 font-bold rounded-lg text-xs hover:bg-slate-850">
                Reset Search
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($hotels as $htl)
                <div class="glass-card rounded-2xl overflow-hidden hover-scale flex flex-col h-full border border-slate-800 animate-slide-in">
                    <div class="h-56 relative overflow-hidden">
                        <img src="{{ $htl->image_url }}" alt="{{ $htl->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-amber-500/95 text-slate-950 font-bold px-2.5 py-0.5 rounded text-xs flex items-center space-x-1 shadow-md">
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
                        <div class="border-t border-slate-800/80 pt-4 flex items-center justify-between mt-auto">
                            <span class="text-xs text-slate-500 line-clamp-1 max-w-[60%]">{{ $htl->address }}</span>
                            <a href="{{ route('hotels.show', $htl->id) }}" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-md">
                                View Rooms
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
