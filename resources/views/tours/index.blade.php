<x-app-layout>
    <x-slot name="header">
        Explore Tour Packages
    </x-slot>

    <!-- Search/Filter panel -->
    <div class="glass-card p-6 rounded-2xl mb-10 shadow-lg border border-slate-800">
        <form action="{{ route('tours.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Search Key</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Destination, keywords..." class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Max Price (₹)</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="e.g. 50000" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Max Duration (Days)</label>
                <select name="duration" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
                    <option value="">Any Duration</option>
                    <option value="3" {{ request('duration') == 3 ? 'selected' : '' }}>Up to 3 Days</option>
                    <option value="5" {{ request('duration') == 5 ? 'selected' : '' }}>Up to 5 Days</option>
                    <option value="7" {{ request('duration') == 7 ? 'selected' : '' }}>Up to 7 Days</option>
                    <option value="10" {{ request('duration') == 10 ? 'selected' : '' }}>Up to 10 Days</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-sm transition">
                    Filter Packages
                </button>
            </div>
        </form>
    </div>

    <!-- Package Grid -->
    @if($packages->isEmpty())
        <div class="text-center py-20 glass-card rounded-3xl">
            <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-xl font-bold text-white mb-2">No tour packages match your filters</h3>
            <p class="text-slate-400 text-sm">Try broadening your search criteria or resetting filters.</p>
            <a href="{{ route('tours.index') }}" class="inline-block mt-4 px-4 py-2 bg-slate-900 border border-slate-800 text-indigo-400 font-bold rounded-lg text-xs hover:bg-slate-850">
                Clear Filters
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($packages as $pkg)
                <div class="glass-card rounded-2xl overflow-hidden hover-scale flex flex-col h-full border border-slate-800 animate-slide-in">
                    <div class="h-56 relative overflow-hidden">
                        <img src="{{ $pkg->image_url }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-4 right-4 bg-slate-950/80 backdrop-blur-md text-xs font-mono font-bold text-indigo-400 px-3 py-1 rounded-full border border-slate-700 shadow-md">
                            {{ $pkg->duration_days }} Days
                        </span>
                        <span class="absolute bottom-4 left-4 bg-emerald-950/80 backdrop-blur-md text-[10px] font-bold text-emerald-400 px-2 py-0.5 rounded border border-emerald-500/20 shadow-md">
                            {{ $pkg->available_slots }} / {{ $pkg->max_slots }} Seats Available
                        </span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs text-indigo-400 font-mono font-semibold">{{ $pkg->destination->name }}, {{ $pkg->destination->location }}</span>
                            <h3 class="text-xl font-bold text-white mt-1 mb-3">{{ $pkg->name }}</h3>
                            <p class="text-slate-400 text-sm line-clamp-3 mb-6">{{ $pkg->description }}</p>
                        </div>
                        <div class="flex items-center justify-between border-t border-slate-800/80 pt-4 mt-auto">
                            <div>
                                <span class="text-xs text-slate-500 block uppercase">Price per guest</span>
                                <span class="text-2xl font-black text-indigo-400">₹{{ number_format($pkg->price, 2) }}</span>
                            </div>
                            <a href="{{ route('tours.show', $pkg->id) }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition duration-150 shadow-md">
                                Explore Tour
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
