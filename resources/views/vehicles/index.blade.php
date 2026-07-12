<x-app-layout>
    <x-slot name="header">
        Explore Rental Vehicles
    </x-slot>

    <!-- Search Filters -->
    <div class="glass-card p-6 rounded-2xl mb-10 shadow-lg border border-slate-800">
        <form action="{{ route('vehicles.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Vehicle Type</label>
                <select name="type" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
                    <option value="">Any Type</option>
                    <option value="SUV (Electric)" {{ request('type') === 'SUV (Electric)' ? 'selected' : '' }}>Electric SUV</option>
                    <option value="SUV (Premium)" {{ request('type') === 'SUV (Premium)' ? 'selected' : '' }}>Premium SUV</option>
                    <option value="Minibus" {{ request('type') === 'Minibus' ? 'selected' : '' }}>Minibus / Van</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Min Capacity (Passengers)</label>
                <input type="number" name="capacity" value="{{ request('capacity') }}" placeholder="e.g. 5" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Max Price per Day (₹)</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="e.g. 2500" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-sm transition">
                    Filter Vehicles
                </button>
            </div>
        </form>
    </div>

    <!-- Vehicles Grid -->
    @if($vehicles->isEmpty())
        <div class="text-center py-20 glass-card rounded-3xl">
            <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            <h3 class="text-xl font-bold text-white mb-2">No vehicles found</h3>
            <p class="text-slate-400 text-sm">Try relaxing your search criteria or resetting filters.</p>
            <a href="{{ route('vehicles.index') }}" class="inline-block mt-4 px-4 py-2 bg-slate-900 border border-slate-800 text-indigo-400 font-bold rounded-lg text-xs hover:bg-slate-850">
                Clear Filters
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($vehicles as $vh)
                <div class="glass-card rounded-2xl overflow-hidden hover-scale flex flex-col h-full border border-slate-800 animate-slide-in">
                    <div class="h-56 relative overflow-hidden">
                        <img src="{{ $vh->image_url }}" alt="{{ $vh->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-4 right-4 bg-slate-950/80 backdrop-blur-md text-xs font-mono font-bold text-indigo-400 px-3 py-1 rounded-full border border-slate-700 shadow-md">
                            {{ $vh->type }}
                        </span>
                        <span class="absolute bottom-4 left-4 bg-slate-950/80 backdrop-blur-md text-[10px] font-bold text-slate-300 px-2 py-0.5 rounded border border-slate-700 shadow-md">
                            Cap: {{ $vh->capacity }} Passengers
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs text-indigo-400 font-mono font-semibold">{{ $vh->provider_name }}</span>
                            <h3 class="text-xl font-bold text-white mt-1 mb-2">{{ $vh->name }}</h3>
                            <span class="text-2xl font-black text-indigo-400 font-mono">₹{{ number_format($vh->price_per_day, 2) }}</span>
                            <span class="text-xs text-slate-500 font-mono">/ day</span>
                        </div>
                    </div>

                    <!-- Date range selector and checkout button -->
                    <div class="p-6 bg-slate-900/40 border-t border-slate-800/80">
                        <form action="{{ route('booking.checkout') }}" method="GET" class="space-y-4">
                            <input type="hidden" name="bookable_type" value="{{ \App\Models\Vehicle::class }}">
                            <input type="hidden" name="bookable_id" value="{{ $vh->id }}">

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1 font-mono">Start Date</label>
                                    <input type="date" name="start_date" required min="{{ date('Y-m-d') }}" class="w-full px-3 py-1.5 rounded-lg glass-input text-xs" value="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1 font-mono">End Date</label>
                                    <input type="date" name="end_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3 py-1.5 rounded-lg glass-input text-xs" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                            </div>

                            @auth
                                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition uppercase tracking-wider shadow-md">
                                    Rent Vehicle
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="w-full block text-center py-2.5 bg-slate-900 border border-slate-850 hover:bg-slate-800 text-indigo-400 text-xs font-bold rounded-xl transition">
                                    Login to Reserve
                                </a>
                            @endauth
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
