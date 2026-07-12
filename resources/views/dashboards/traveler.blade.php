<x-app-layout>
    <x-slot name="header">
        Welcome Back, {{ auth()->user()->name }} 👋
    </x-slot>

    <!-- Stat Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 animate-slide-in">
        <div class="glass-card p-6 rounded-2xl border-l-4 border-indigo-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Total Travel Investment</span>
            <h3 class="text-3xl font-black text-white">₹{{ number_format($totalSpent, 2) }}</h3>
            <p class="text-xs text-slate-500 mt-2">Verified payments across all bookings</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 border-purple-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Active AI Trip Plans</span>
            <h3 class="text-3xl font-black text-white">{{ $activeTripsCount }}</h3>
            <p class="text-xs text-slate-500 mt-2">Saved customized itineraries</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 border-emerald-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Account Role</span>
            <h3 class="text-3xl font-black text-emerald-400 capitalize">{{ auth()->user()->role }}</h3>
            <p class="text-xs text-slate-500 mt-2">Accessing traveler suite features</p>
        </div>
    </div>

    <!-- Main Content Divider -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: AI Trip Plans -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card p-6 rounded-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        <span>My AI Custom Trips</span>
                    </h3>
                    <a href="{{ route('trip.planner') }}" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-xs font-bold rounded-lg text-white transition">
                        + New AI Trip
                    </a>
                </div>

                @if($trips->isEmpty())
                    <div class="text-center py-10 border border-dashed border-slate-800 rounded-xl">
                        <svg class="w-12 h-12 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <p class="text-slate-400 text-sm mb-4">You have not generated any AI itineraries yet.</p>
                        <a href="{{ route('trip.planner') }}" class="inline-block px-4 py-2 bg-slate-900 border border-slate-800 text-indigo-400 text-xs font-bold rounded-lg hover:bg-slate-800">
                            Build Your First Plan
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($trips as $trip)
                            <div class="glass-card-light p-4 rounded-xl border border-slate-900 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between">
                                        <h4 class="font-bold text-white text-base">{{ $trip->title }}</h4>
                                        <span class="text-xs px-2 py-0.5 bg-indigo-500/10 text-indigo-400 rounded border border-indigo-500/20 font-mono">
                                            {{ $trip->start_date->diffInDays($trip->end_date) + 1 }} Days
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 font-mono mt-1">{{ $trip->destination }}</p>
                                    <div class="mt-4 flex items-center justify-between text-xs text-slate-400 font-mono">
                                        <span>Budget: <strong>₹{{ number_format($trip->budget, 0) }}</strong></span>
                                        <span>Date: {{ $trip->start_date->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center gap-2 border-t border-slate-800/80 pt-3">
                                    <a href="{{ route('trip.show', $trip->id) }}" class="flex-grow text-center py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition">
                                        Open Daily Planner
                                    </a>
                                    <form action="{{ route('trip.destroy', $trip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip plan?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-red-950/20 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition text-xs font-bold">
                                            🗑
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Booking Section -->
            <div class="glass-card p-6 rounded-2xl">
                <h3 class="text-xl font-bold text-white flex items-center space-x-2 mb-6">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <span>My Booking History</span>
                </h3>

                @if($bookings->isEmpty())
                    <div class="text-center py-10 border border-dashed border-slate-800 rounded-xl">
                        <p class="text-slate-400 text-sm">You do not have any active bookings yet.</p>
                        <div class="mt-4 flex items-center justify-center space-x-3">
                            <a href="{{ route('tours.index') }}" class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-bold rounded-lg">Browse Tours</a>
                            <a href="{{ route('hotels.index') }}" class="px-3 py-1.5 bg-slate-900 border border-slate-800 text-indigo-400 text-xs font-bold rounded-lg">Find Hotels</a>
                        </div>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            <div class="glass-card-light p-5 rounded-xl border border-slate-950 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <!-- Bookable Type Badge -->
                                        @if($booking->bookable_type === \App\Models\TourPackage::class)
                                            <span class="text-[10px] px-2 py-0.5 bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 rounded font-semibold uppercase">Tour Package</span>
                                        @elseif($booking->bookable_type === \App\Models\HotelRoom::class)
                                            <span class="text-[10px] px-2 py-0.5 bg-purple-500/10 border border-purple-500/20 text-purple-300 rounded font-semibold uppercase">Hotel Booking</span>
                                        @elseif($booking->bookable_type === \App\Models\Vehicle::class)
                                            <span class="text-[10px] px-2 py-0.5 bg-cyan-500/10 border border-cyan-500/20 text-cyan-300 rounded font-semibold uppercase">Vehicle Rental</span>
                                        @endif

                                        <!-- Status Badge -->
                                        @if($booking->status === 'confirmed')
                                            <span class="text-[10px] px-2 py-0.5 bg-emerald-500/10 text-emerald-400 rounded font-bold uppercase border border-emerald-500/20">Confirmed</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="text-[10px] px-2 py-0.5 bg-red-500/10 text-red-400 rounded font-bold uppercase border border-red-500/20">Cancelled</span>
                                        @else
                                            <span class="text-[10px] px-2 py-0.5 bg-amber-500/10 text-amber-400 rounded font-bold uppercase border border-amber-500/20">{{ $booking->status }}</span>
                                        @endif
                                    </div>

                                    <h4 class="font-bold text-white text-lg mt-2">
                                        @if($booking->bookable)
                                            {{ $booking->bookable->name ?? $booking->bookable->room_type }}
                                        @else
                                            <span class="text-slate-500 font-normal italic">Item unavailable</span>
                                        @endif
                                    </h4>

                                    <p class="text-xs text-slate-400 mt-1 font-mono">
                                        Date range: {{ $booking->start_date->format('M d, Y') }} 
                                        @if($booking->end_date)
                                            - {{ $booking->end_date->format('M d, Y') }}
                                        @endif
                                    </p>
                                </div>

                                <div class="flex flex-row md:flex-col items-start md:items-end justify-between md:justify-center gap-2 border-t md:border-t-0 border-slate-800/80 pt-3 md:pt-0">
                                    <div class="text-left md:text-right">
                                        <span class="text-[10px] text-slate-500 block uppercase font-mono">Paid price</span>
                                        <span class="text-xl font-black text-indigo-400">₹{{ number_format($booking->total_price, 2) }}</span>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('booking.show', $booking->id) }}" class="px-3 py-1.5 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-200 text-xs font-bold rounded-lg transition">
                                            Ticket Receipt
                                        </a>

                                        @if($booking->status === 'confirmed')
                                            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking and claim a full refund?')" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-red-950/20 border border-red-500/30 text-red-400 hover:bg-red-600 hover:text-white text-xs font-bold rounded-lg transition">
                                                    Cancel / Refund
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Profile Info & Assistant shortcuts -->
        <div class="space-y-8">
            <div class="glass-card p-6 rounded-2xl text-center">
                <div class="relative w-24 h-24 mx-auto mb-4 flex items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 border-2 border-indigo-500 shadow-lg select-none">
                    <span class="text-3xl font-black text-white uppercase font-mono tracking-wider">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span class="absolute bottom-0 right-0 w-4 h-4 bg-emerald-500 border-2 border-slate-950 rounded-full" title="Online"></span>
                </div>
                <h3 class="text-xl font-bold text-white">{{ auth()->user()->name }}</h3>
                <span class="text-xs font-mono text-slate-400">{{ auth()->user()->email }}</span>
                
                @if(auth()->user()->phone)
                    <p class="text-xs text-slate-500 font-mono mt-1">{{ auth()->user()->phone }}</p>
                @endif

                @if(auth()->user()->bio)
                    <p class="text-sm text-slate-400 mt-4 px-2 leading-relaxed">
                        "{{ auth()->user()->bio }}"
                    </p>
                @endif

                <div class="mt-6 border-t border-slate-800/80 pt-6">
                    <a href="{{ route('profile.edit') }}" class="w-full inline-block text-center py-2.5 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-200 text-xs font-bold rounded-lg transition">
                        Edit Profile Details
                    </a>
                </div>
            </div>

            <!-- Quick AI Assistant -->
            <div class="glass-card p-6 rounded-2xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                
                <h3 class="text-lg font-bold text-white mb-2 flex items-center space-x-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span>24/7 AI Travel Bot</span>
                </h3>
                <p class="text-slate-400 text-xs leading-relaxed mb-6">
                    Have questions about hotel check-in times, attractions in Paris, or transport guidelines? Talk directly with our context-aware agent.
                </p>

                <a href="{{ route('chat.index') }}" class="w-full inline-block text-center py-3 bg-gradient-brand text-white text-xs font-bold rounded-xl hover:shadow-lg hover:shadow-indigo-500/10 transition">
                    Start Assistant Chat
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
