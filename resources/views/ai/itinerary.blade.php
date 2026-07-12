<x-app-layout>
    <x-slot name="title">Generated AI Itinerary - GlobeFly Adventures</x-slot>

    @push('styles')
        <!-- Leaflet Map CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endpush

    <!-- Header metadata -->
    <div class="mb-10 animate-slide-in">
        <span class="text-xs uppercase font-mono tracking-widest text-indigo-400 font-bold">AI Recommendation Engine</span>
        <h2 class="text-3xl font-black text-white mt-1">{{ $itineraryData['title'] ?? 'Customized Travel Plan' }}</h2>
        <p class="text-slate-400 text-xs mt-2">
            Trip to <strong class="text-white">{{ ucwords($destination) }}</strong> for <strong class="text-white">{{ $days }} Days</strong> on a budget of <strong class="text-white">₹{{ number_format($budget, 0) }}</strong>.
        </p>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        
        <!-- Left: Day-by-Day agenda timeline -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card p-6 md:p-8 rounded-3xl">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Day-by-Day Agenda</span>
                </h3>

                <div class="space-y-10">
                    @foreach($itineraryData['days'] as $day)
                        <div class="relative pl-6 border-l-2 border-indigo-500/20">
                            <!-- Daily Badge Pin -->
                            <div class="absolute -left-2 top-0.5 w-3.5 h-3.5 bg-indigo-500 rounded-full border-4 border-slate-950"></div>
                            
                            <div class="mb-4">
                                <span class="text-xs font-bold text-indigo-400 font-mono uppercase">Day {{ $day['day'] }}</span>
                                <h4 class="text-lg font-black text-white mt-0.5">{{ $day['theme'] ?? 'Exploring the Region' }}</h4>
                            </div>

                            <!-- Daily Activities Stack -->
                            <div class="space-y-4">
                                @foreach($day['activities'] as $act)
                                    <div class="glass-card-light p-4 rounded-xl border border-slate-950/60 flex items-start justify-between gap-4">
                                        <div>
                                            <div class="flex items-center space-x-2 mb-1">
                                                <span class="text-xs text-indigo-300 font-mono font-bold">{{ $act['time'] }}</span>
                                                <span class="text-[10px] bg-slate-900 border border-slate-800 text-slate-400 font-mono px-2 py-0.5 rounded capitalize">
                                                    {{ $act['category'] ?? 'other' }}
                                                </span>
                                            </div>
                                            <h5 class="font-bold text-white text-sm">{{ $act['title'] }}</h5>
                                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $act['description'] }}</p>
                                        </div>
                                        @if(isset($act['cost']) && $act['cost'] > 0)
                                            <span class="text-xs font-mono font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded shrink-0">
                                                +₹{{ number_format($act['cost'], 0) }}
                                            </span>
                                        @else
                                            <span class="text-xs font-mono font-bold text-slate-400 bg-slate-800 border border-slate-700 px-2 py-0.5 rounded shrink-0">
                                                Free
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Map and Save Actions -->
        <div class="space-y-8">
            <!-- Leaflet Interactive Map -->
            <div class="glass-card p-6 rounded-3xl relative overflow-hidden">
                <h3 class="text-lg font-bold text-white mb-4">Itinerary Map Sights</h3>
                <div id="map" class="h-80 w-full rounded-2xl border border-slate-850 shadow-inner z-10"></div>
                <p class="text-[10px] text-slate-500 font-mono mt-3 text-center">
                    Leaflet.js &copy; OpenStreetMap contributors
                </p>
            </div>

            <!-- Save Plan Actions Card -->
            <div class="glass-card p-6 rounded-3xl border border-slate-800">
                <h3 class="text-lg font-bold text-white mb-4">Save Trip Itinerary</h3>
                <p class="text-slate-400 text-xs leading-relaxed mb-6">
                    Save this itinerary to your profile to record daily costs, track expenses with interactive charts, and retrieve details anytime.
                </p>

                <div class="border-b border-slate-850 pb-4 mb-6">
                    <span class="text-xs text-slate-500 font-mono block uppercase">Total Estimated Costs</span>
                    <span class="text-3xl font-black text-indigo-400 font-mono">
                        ₹{{ number_format($itineraryData['total_estimated_cost'] ?? 0, 2) }}
                    </span>
                </div>

                <form action="{{ route('trip.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="Trip to {{ ucwords($destination) }}">
                    <input type="hidden" name="destination" value="{{ ucwords($destination) }}">
                    <input type="hidden" name="start_date" value="{{ $startDate }}">
                    <input type="hidden" name="end_date" value="{{ $endDate }}">
                    <input type="hidden" name="budget" value="{{ $budget }}">
                    <input type="hidden" name="preferences" value="{{ json_encode(['interests' => $interests]) }}">
                    <input type="hidden" name="itinerary_data" value="{{ json_encode($itineraryData) }}">

                    <button type="submit" class="w-full py-3.5 bg-gradient-brand text-white font-bold rounded-xl text-xs uppercase tracking-wider hover:shadow-lg hover:shadow-indigo-500/25 transition">
                        Save Plan to Dashboard
                    </button>
                </form>
                <a href="{{ route('trip.planner') }}" class="w-full mt-3 inline-block text-center py-3 bg-slate-900 border border-slate-850 text-slate-400 font-bold rounded-xl text-xs hover:bg-slate-800 transition">
                    Discard and Start Over
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Leaflet Map JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Determine Map Center based on destination
                let lat = 20.5937;
                let lng = 78.9629; // Default India Center
                
                const destination = "{{ strtolower($destination) }}";
                
                if (destination.includes('taj') || destination.includes('agra')) {
                    lat = 27.1751; lng = 78.0421;
                } else if (destination.includes('goa')) {
                    lat = 15.2993; lng = 74.1240;
                } else if (destination.includes('kerala')) {
                    lat = 10.8505; lng = 76.2711;
                } else if (destination.includes('jaipur') || destination.includes('rajasthan')) {
                    lat = 26.9124; lng = 75.7873;
                } else if (destination.includes('ladakh') || destination.includes('leh')) {
                    lat = 34.1526; lng = 77.5770;
                } else if (destination.includes('delhi')) {
                    lat = 28.6139; lng = 77.2090;
                } else if (destination.includes('kyoto') || destination.includes('japan')) {
                    lat = 35.0116; lng = 135.7681;
                } else if (destination.includes('paris') || destination.includes('france')) {
                    lat = 48.8566; lng = 2.3522;
                } else if (destination.includes('swiss') || destination.includes('alps') || destination.includes('switzerland')) {
                    lat = 46.5586; lng = 8.5284;
                } else if (destination.includes('bali') || destination.includes('indonesia')) {
                    lat = -8.4095; lng = 115.1889;
                } else if (destination.includes('york') || destination.includes('nyc') || destination.includes('usa')) {
                    lat = 40.7128; lng = -74.0060;
                }
                
                // Initialize map
                const map = L.map('map').setView([lat, lng], 12);
                
                // Add OpenStreetMap tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                
                // Add custom marker
                L.marker([lat, lng]).addTo(map)
                    .bindPopup("<strong class='text-slate-900'>Itinerary Target: {{ ucwords($destination) }}</strong>")
                    .openPopup();
            });
        </script>
    @endpush
</x-app-layout>
