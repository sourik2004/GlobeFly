<x-app-layout>
    <x-slot name="title">{{ $package->name }} - GlobeFly Adventures</x-slot>

    <div class="relative h-96 rounded-3xl overflow-hidden mb-12 border border-slate-800 shadow-2xl">
        <img src="{{ $package->image_url }}" class="w-full h-full object-cover" alt="package header">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
        <div class="absolute bottom-8 left-8 md:left-12">
            <span class="text-xs font-mono uppercase bg-indigo-600 text-white font-bold px-3 py-1 rounded-full border border-indigo-400/40 mb-3 inline-block">
                {{ $package->duration_days }} Days Tour
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-white leading-tight">
                {{ $package->name }}
            </h1>
            <p class="text-slate-300 text-sm md:text-base mt-2 flex items-center space-x-2">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>{{ $package->destination->name }}, {{ $package->destination->location }}</span>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Details Column -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card p-8 rounded-2xl">
                <h3 class="text-xl font-bold text-white mb-4">Tour Overview</h3>
                <p class="text-slate-350 text-sm leading-relaxed mb-6 font-normal">
                    {{ $package->description }}
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-slate-800/80 pt-6">
                    <div>
                        <span class="text-xs text-slate-500 font-mono block uppercase">Start date</span>
                        <span class="font-bold text-white text-sm">{{ $package->start_date->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-mono block uppercase">End date</span>
                        <span class="font-bold text-white text-sm">{{ $package->end_date->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-mono block uppercase">Destination weather guidelines</span>
                        <span class="font-bold text-indigo-300 text-xs">{{ $package->destination->weather_info ?? 'Standard seasonal wear.' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-mono block uppercase">Tour operator</span>
                        <span class="font-bold text-white text-sm">{{ $package->manager->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Simulated Daily Itinerary -->
            <div class="glass-card p-8 rounded-2xl">
                <h3 class="text-xl font-bold text-white mb-6">Planned Daily Activities</h3>
                <div class="space-y-6">
                    @for($i = 1; $i <= $package->duration_days; $i++)
                        <div class="relative pl-8 border-l border-slate-800 pb-2 last:pb-0">
                            <!-- Bullet -->
                            <div class="absolute -left-1.5 top-1.5 w-3 h-3 bg-indigo-500 rounded-full border-2 border-slate-950"></div>
                            
                            <h4 class="font-bold text-white text-base">Day {{ $i }} — Tour Highlights</h4>
                            <p class="text-slate-400 text-xs mt-1 leading-relaxed">
                                Morning guided sightseeing across major cultural landmarks, lunch stopovers featuring local gourmet specialties, followed by free exploration hours and scenic sunset photography opportunities.
                            </p>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Checkout Ticket Card -->
        <div>
            <div class="glass-card p-6 rounded-2xl border border-slate-800 sticky top-24">
                <h3 class="text-lg font-bold text-white mb-4">Secure Tour Registration</h3>
                
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
                    <div>
                        <span class="text-slate-500 text-xs uppercase block">Per guest ticket</span>
                        <span class="text-3xl font-black text-indigo-400">₹{{ number_format($package->price, 2) }}</span>
                    </div>
                    <span class="text-xs px-2 py-0.5 bg-slate-900 border border-slate-800 text-slate-400 font-mono rounded">
                        All-Inclusive
                    </span>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-xs font-mono text-slate-400">
                        <span>Available Seats:</span>
                        <span class="font-bold text-white">{{ $package->available_slots }} / {{ $package->max_slots }}</span>
                    </div>
                    <div class="flex justify-between text-xs font-mono text-slate-400">
                        <span>Duration:</span>
                        <span class="font-bold text-white">{{ $package->duration_days }} Days</span>
                    </div>
                </div>

                @if($package->available_slots > 0)
                    @auth
                        <a href="{{ route('booking.checkout') }}?bookable_type={{ urlencode(\App\Models\TourPackage::class) }}&bookable_id={{ $package->id }}" 
                           class="w-full inline-block text-center py-3.5 bg-gradient-brand text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/25 transition hover:scale-105 duration-200">
                            Book Tickets
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full inline-block text-center py-3.5 bg-slate-900 border border-slate-850 hover:bg-slate-800 text-indigo-400 font-bold rounded-xl transition">
                            Login to Register
                        </a>
                    @endauth
                @else
                    <button disabled class="w-full py-3.5 bg-slate-800 text-slate-500 font-bold rounded-xl cursor-not-allowed text-center">
                        Sold Out
                    </button>
                @endif
                
                <p class="text-[10px] text-slate-500 text-center mt-4">
                    *Free cancellations and full refund guarantees up to 48 hours prior to start date.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
