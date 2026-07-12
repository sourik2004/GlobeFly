<x-app-layout>
    <x-slot name="title">{{ $trip->title }} - GlobeFly Adventures</x-slot>

    @push('styles')
        <!-- Leaflet Map CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endpush

    <!-- Header info -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10 animate-slide-in">
        <div>
            <span class="text-xs uppercase font-mono tracking-widest text-indigo-400 font-bold">Saved Itinerary</span>
            <h2 class="text-3xl font-black text-white mt-1">{{ $trip->title }}</h2>
            <p class="text-slate-450 text-xs mt-1">
                Travel Dates: {{ $trip->start_date->format('M d, Y') }} — {{ $trip->end_date->format('M d, Y') }} 
                ({{ $trip->start_date->diffInDays($trip->end_date) + 1 }} Days)
            </p>
        </div>
        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-900 border border-slate-800 text-slate-300 rounded-xl hover:bg-slate-800 text-sm font-bold text-center">
            Back to Dashboard
        </a>
    </div>

    <!-- Stats Grid (Financial Planner) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="glass-card p-6 rounded-2xl border-l-4 border-indigo-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Trip Budget Limit</span>
            <h3 class="text-3xl font-black text-white">₹{{ number_format($trip->budget, 2) }}</h3>
            <p class="text-xs text-slate-500 mt-2">Maximum allocated budget target</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 border-amber-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Total Logged Spent</span>
            <h3 class="text-3xl font-black text-white">₹{{ number_format($totalSpent, 2) }}</h3>
            <p class="text-xs text-slate-500 mt-2">Active records across all categories</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 {{ $remainingBudget >= 0 ? 'border-emerald-500' : 'border-red-500' }}">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Remaining Balance</span>
            <h3 class="text-3xl font-black {{ $remainingBudget >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                ₹{{ number_format($remainingBudget, 2) }}
            </h3>
            <p class="text-xs text-slate-500 mt-2">
                {{ $remainingBudget >= 0 ? 'Within budget bounds' : 'Budget target exceeded!' }}
            </p>
        </div>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        
        <!-- Left: Agenda & Daily Sights -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card p-6 md:p-8 rounded-3xl">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Trip Daily Itinerary</span>
                </h3>

                <div class="space-y-8">
                    @foreach($trip->itinerary_data['days'] as $day)
                        <div class="relative pl-6 border-l-2 border-indigo-500/20">
                            <div class="absolute -left-2 top-0.5 w-3.5 h-3.5 bg-indigo-500 rounded-full border-4 border-slate-950"></div>
                            
                            <div class="mb-4">
                                <span class="text-xs font-bold text-indigo-400 font-mono uppercase">Day {{ $day['day'] }}</span>
                                <h4 class="text-lg font-black text-white mt-0.5">{{ $day['theme'] ?? 'Exploring Sights' }}</h4>
                            </div>

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
                                        <span class="text-xs font-mono font-bold text-slate-300 bg-slate-800 border border-slate-700 px-2 py-0.5 rounded shrink-0">
                                            {{ isset($act['cost']) && $act['cost'] > 0 ? '$'.number_format($act['cost'], 0) : 'Free' }}
                                        </span>
                                    </div>
                                </endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Map, Charts & Expense logs -->
        <div class="space-y-8">
            <!-- Leaflet Map -->
            <div class="glass-card p-6 rounded-3xl relative overflow-hidden">
                <h3 class="text-lg font-bold text-white mb-4">Destination Sightseeing Map</h3>
                <div id="map" class="h-64 w-full rounded-xl border border-slate-850 shadow-inner z-10"></div>
            </div>

            <!-- Expense Category Doughnut Chart -->
            <div class="glass-card p-6 rounded-3xl">
                <h3 class="text-lg font-bold text-white mb-4">Expenses Category Analysis</h3>
                @if($trip->expenses->isEmpty())
                    <p class="text-slate-500 text-xs italic text-center py-6">Chart is empty. Add logged expenses below to calculate ratios.</p>
                @else
                    <div class="relative w-full h-56 flex items-center justify-center">
                        <canvas id="expenseChart"></canvas>
                    </div>
                @endif
            </div>

            <!-- Log Expense Form -->
            <div class="glass-card p-6 rounded-3xl">
                <h3 class="text-lg font-bold text-white mb-4">Add Travel Expense</h3>
                <form action="{{ route('expense.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Expense Title</label>
                        <input type="text" name="title" required placeholder="e.g. Souvenirs, Lunch at cafe" class="w-full px-3 py-2 rounded-lg glass-input text-xs">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Amount (₹)</label>
                            <input type="number" step="0.01" name="amount" required placeholder="2000" class="w-full px-3 py-2 rounded-lg glass-input text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Date</label>
                            <input type="date" name="expense_date" required min="{{ $trip->start_date->toDateString() }}" max="{{ $trip->end_date->toDateString() }}" class="w-full px-3 py-2 rounded-lg glass-input text-xs" value="{{ $trip->start_date->toDateString() }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Category</label>
                        <select name="category" required class="w-full px-3 py-2 rounded-lg glass-input text-xs">
                            <option value="food">🍜 Food & Gastronomy</option>
                            <option value="transport">🚇 Transport & Transit</option>
                            <option value="accommodation">🏨 Accommodation</option>
                            <option value="activities">⛲ Sightseeing & Tours</option>
                            <option value="shopping">🛍 Shopping</option>
                            <option value="other">📦 Other</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2 bg-indigo-650 hover:bg-indigo-700 text-white font-bold rounded-lg text-xs uppercase tracking-wider transition">
                        Log Expense
                    </button>
                </form>
            </div>

            <!-- Expense logs List -->
            <div class="glass-card p-6 rounded-3xl">
                <h3 class="text-lg font-bold text-white mb-4">Cost Ledger</h3>
                @if($trip->expenses->isEmpty())
                    <p class="text-slate-500 text-xs italic text-center py-4">No logged costs yet.</p>
                @else
                    <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                        @foreach($trip->expenses as $exp)
                            <div class="flex items-center justify-between p-3 bg-slate-900/60 border border-slate-850 rounded-xl">
                                <div>
                                    <div class="font-bold text-white text-xs">{{ $exp->title }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono">
                                        {{ $exp->expense_date->format('M d') }} — <span class="capitalize text-indigo-400">{{ $exp->category }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs font-mono font-bold text-white">₹{{ number_format($exp->amount, 2) }}</span>
                                    <form action="{{ route('expense.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Remove cost item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-xs">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Leaflet Map JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Leaflet Map Logic
                let lat = 20.5937;
                let lng = 78.9629; // Default India Center
                
                const destination = "{{ strtolower($trip->destination) }}";
                
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
                
                const map = L.map('map').setView([lat, lng], 12);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                
                L.marker([lat, lng]).addTo(map)
                    .bindPopup("<strong class='text-slate-900'>Itinerary Target: {{ ucwords($trip->destination) }}</strong>")
                    .openPopup();

                // Chart.js Category Breakdown Logic
                @if(!$trip->expenses->isEmpty())
                    const ctx = document.getElementById('expenseChart').getContext('2d');
                    
                    const data = {
                        labels: {!! json_encode($expensesByCategory->keys()->map(fn($c) => ucfirst($c))->toArray()) !!},
                        datasets: [{
                            data: {!! json_encode($expensesByCategory->values()->toArray()) !!},
                            backgroundColor: [
                                '#f87171', // food - red
                                '#60a5fa', // transport - blue
                                '#c084fc', // accommodation - purple
                                '#34d399', // activities - green
                                '#fb7185', // shopping - pink
                                '#94a3b8'  // other - slate
                            ],
                            borderWidth: 1,
                            borderColor: '#0f172a'
                        }]
                    };

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: '#cbd5e1',
                                        font: {
                                            size: 10
                                        }
                                    }
                                }
                            }
                        }
                    });
                @endif
            });
        </script>
    @endpush
</x-app-layout>
