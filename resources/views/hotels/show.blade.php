<x-app-layout>
    <x-slot name="title">{{ $hotel->name }} - GlobeFly Adventures</x-slot>

    <!-- Header section -->
    <div class="relative h-80 rounded-3xl overflow-hidden mb-12 border border-slate-800 shadow-2xl">
        <img src="{{ $hotel->image_url }}" class="w-full h-full object-cover" alt="hotel detail header">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
        <div class="absolute bottom-8 left-8">
            <div class="flex items-center space-x-2 bg-amber-500/95 text-slate-950 font-bold px-2.5 py-0.5 rounded text-xs mb-3 inline-block shadow-md">
                <span>★</span>
                <span>{{ $hotel->star_rating }} Star Accommodation</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-white leading-tight">
                {{ $hotel->name }}
            </h1>
            <p class="text-slate-300 text-sm mt-2 flex items-center space-x-2">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>{{ $hotel->location }} — {{ $hotel->address }}</span>
            </p>
        </div>
    </div>

    <!-- Details/Description -->
    <div class="glass-card p-8 rounded-2xl mb-12">
        <h3 class="text-xl font-bold text-white mb-4">About the Hotel</h3>
        <p class="text-slate-350 text-sm leading-relaxed mb-6 font-normal">
            {{ $hotel->description }}
        </p>
    </div>

    <!-- Rooms Listings -->
    <h2 class="text-2xl font-bold text-white mb-8">Available Rooms & Suites</h2>
    
    @if($hotel->rooms->isEmpty())
        <div class="text-center py-12 glass-card rounded-2xl">
            <p class="text-slate-400 italic">No room structures are currently configured for this hotel.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($hotel->rooms as $room)
                <div class="glass-card rounded-2xl overflow-hidden border border-slate-800 flex flex-col justify-between">
                    <div>
                        <!-- Room Image -->
                        <div class="h-64 relative overflow-hidden">
                            <img src="{{ $room->image_url }}" alt="{{ $room->room_type }}" class="w-full h-full object-cover">
                            <span class="absolute top-4 right-4 bg-slate-950/80 backdrop-blur-md text-xs font-mono font-bold text-indigo-400 px-3 py-1 rounded-full border border-slate-700 shadow-md">
                                Cap: {{ $room->capacity }} Guests
                            </span>
                        </div>
                        
                        <!-- Room Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $room->room_type }}</h3>
                            <span class="text-2xl font-black text-indigo-400 font-mono">₹{{ number_format($room->price_per_night, 2) }}</span>
                            <span class="text-xs text-slate-500 font-mono">/ night</span>
                            
                            <!-- Amenities -->
                            <div class="mt-4 border-t border-slate-800/80 pt-4">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2 font-mono">Amenities included</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach((array)$room->amenities as $am)
                                        <span class="text-xs bg-slate-900 border border-slate-800 px-2.5 py-1 rounded-lg text-slate-350 font-mono">{{ $am }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Booking Selector form -->
                    <div class="p-6 bg-slate-900/40 border-t border-slate-800/80">
                        <form action="{{ route('booking.checkout') }}" method="GET" class="space-y-4">
                            <input type="hidden" name="bookable_type" value="{{ \App\Models\HotelRoom::class }}">
                            <input type="hidden" name="bookable_id" value="{{ $room->id }}">

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1 font-mono">Check-in</label>
                                    <input type="date" name="start_date" required min="{{ date('Y-m-day') }}" class="w-full px-3 py-1.5 rounded-lg glass-input text-xs" value="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1 font-mono">Check-out</label>
                                    <input type="date" name="end_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3 py-1.5 rounded-lg glass-input text-xs" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                            </div>

                            @if($room->is_available)
                                @auth
                                    <button type="submit" class="w-full py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition uppercase tracking-wider shadow-md">
                                        Book Room
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="w-full block text-center py-2.5 bg-slate-900 border border-slate-850 hover:bg-slate-800 text-indigo-400 text-xs font-bold rounded-xl transition">
                                        Login to Reserve
                                    </a>
                                @endauth
                            @else
                                <button disabled class="w-full py-2.5 bg-slate-800 text-slate-500 font-bold rounded-xl text-xs cursor-not-allowed">
                                    Unavailable
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
