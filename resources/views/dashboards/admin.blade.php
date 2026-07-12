<x-app-layout>
    <x-slot name="header">
        System Administrative Dashboard
    </x-slot>

    <!-- Stat Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 animate-slide-in">
        <div class="glass-card p-6 rounded-2xl border-l-4 border-indigo-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Cumulative Platform Sales</span>
            <h3 class="text-3xl font-black text-white">₹{{ number_format($totalRevenue, 2) }}</h3>
            <p class="text-xs text-slate-500 mt-2">Combined transactions across all services</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 border-purple-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Registered Users</span>
            <h3 class="text-3xl font-black text-white">{{ $usersCount }}</h3>
            <p class="text-xs text-slate-500 mt-2">Active travelers and business accounts</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 border-emerald-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Platform Transactions</span>
            <h3 class="text-3xl font-black text-white">{{ $bookingsCount }}</h3>
            <p class="text-xs text-slate-500 mt-2">Tour, lodging, and transport checkouts</p>
        </div>
    </div>

    <!-- Administrative Dividers -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Destination Manager (CRUD) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card p-6 rounded-2xl">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Manage Destinations</span>
                </h3>

                <!-- Destination Tables -->
                <div class="overflow-x-auto mb-8 border border-slate-800 rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-900 border-b border-slate-800 text-xs font-mono uppercase text-slate-400">
                                <th class="py-3 px-4">Destination</th>
                                <th class="py-3 px-4">Location</th>
                                <th class="py-3 px-4">Coordinates</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-slate-300 text-xs">
                            @foreach($destinations as $dest)
                                <tr class="hover:bg-slate-900/30 transition">
                                    <td class="py-3 px-4 font-bold text-white flex items-center space-x-2">
                                        <img src="{{ $dest->image_url }}" class="w-8 h-6 rounded object-cover border border-slate-800" alt="dest thumb">
                                        <span>{{ $dest->name }}</span>
                                    </td>
                                    <td class="py-3 px-4">{{ $dest->location }}</td>
                                    <td class="py-3 px-4 font-mono text-[11px] text-slate-400">{{ $dest->coordinates ?? 'None' }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <form action="{{ route('admin.destinations.destroy', $dest->id) }}" method="POST" onsubmit="return confirm('Remove this destination?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 bg-red-950/20 hover:bg-red-600 border border-red-500/30 text-red-400 hover:text-white rounded transition text-[10px] font-bold">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Add Destination Form -->
                <h4 class="text-sm font-bold font-mono text-slate-400 uppercase mb-4">Add Global Destination</h4>
                <form action="{{ route('admin.destinations.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Destination Name</label>
                            <input type="text" name="name" required placeholder="e.g., Rome" class="w-full px-3 py-2 rounded-lg glass-input text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Country / Region</label>
                            <input type="text" name="location" required placeholder="e.g., Italy" class="w-full px-3 py-2 rounded-lg glass-input text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Coordinates (lat, lng)</label>
                            <input type="text" name="coordinates" placeholder="e.g., 41.9028, 12.4964" class="w-full px-3 py-2 rounded-lg glass-input text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Image URL</label>
                            <input type="url" name="image_url" placeholder="https://unsplash.com/..." class="w-full px-3 py-2 rounded-lg glass-input text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Weather Info Guideline</label>
                        <input type="text" name="weather_info" placeholder="e.g., Warm dry summers (22°C - 30°C)" class="w-full px-3 py-2 rounded-lg glass-input text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Description</label>
                        <textarea name="description" rows="2" placeholder="Brief details about sights, attraction centers..." class="w-full px-3 py-2 rounded-lg glass-input text-sm"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-sm transition">
                        Register Destination
                    </button>
                </form>
            </div>

            <!-- Recent bookings audit -->
            <div class="glass-card p-6 rounded-2xl">
                <h3 class="text-xl font-bold text-white mb-6">Recent System Transactions</h3>
                <div class="overflow-x-auto border border-slate-800 rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-900 border-b border-slate-800 text-xs font-mono uppercase text-slate-400">
                                <th class="py-3 px-4">Booking ID</th>
                                <th class="py-3 px-4">Customer</th>
                                <th class="py-3 px-4">Service</th>
                                <th class="py-3 px-4">Price</th>
                                <th class="py-3 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-slate-300 text-xs">
                            @foreach($recentBookings as $bk)
                                <tr class="hover:bg-slate-900/30 transition">
                                    <td class="py-3 px-4 font-mono">#GLB-{{ str_pad($bk->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-3 px-4">
                                        <div class="font-bold text-white">{{ $bk->user->name }}</div>
                                        <div class="text-[10px] text-slate-500 font-mono">{{ $bk->user->email }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $bk->bookable->name ?? $bk->bookable->room_type ?? 'N/A' }}
                                    </td>
                                    <td class="py-3 px-4 font-bold text-white">₹{{ number_format($bk->total_price, 2) }}</td>
                                    <td class="py-3 px-4">
                                        <span class="text-[9px] px-1.5 py-0.5 rounded uppercase font-bold {{ $bk->status === 'confirmed' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-400 border border-slate-700' }}">
                                            {{ $bk->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: User list and role adjustments -->
        <div class="space-y-8">
            <div class="glass-card p-6 rounded-2xl">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>User Roles Manager</span>
                </h3>

                <div class="space-y-4">
                    @php
                        $users = \App\Models\User::latest()->take(10)->get();
                    @endphp

                    @foreach($users as $usr)
                        <div class="glass-card-light p-4 rounded-xl border border-slate-900 flex flex-col justify-between">
                            <div class="flex items-center space-x-3 mb-3">
                                <span class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-[10px] font-black text-white flex items-center justify-center border border-indigo-400/30 uppercase font-mono shrink-0 select-none">
                                    {{ strtoupper(substr($usr->name, 0, 1)) }}
                                </span>
                                <div>
                                    <div class="font-bold text-white text-sm">{{ $usr->name }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono">{{ $usr->email }}</div>
                                </div>
                            </div>

                            <form action="{{ route('admin.users.role', $usr->id) }}" method="POST" class="flex items-center justify-between border-t border-slate-800/80 pt-3">
                                @csrf
                                <span class="text-xs font-mono text-slate-400 capitalize">
                                    Role: <strong class="text-indigo-400 font-bold">{{ str_replace('_', ' ', $usr->role) }}</strong>
                                </span>

                                @if($usr->id !== auth()->id())
                                    <select name="role" onchange="this.form.submit()" class="bg-slate-900 border border-slate-800 text-slate-300 rounded px-2 py-1 text-xs focus:outline-none">
                                        <option value="traveler" {{ $usr->role === 'traveler' ? 'selected' : '' }}>Traveler</option>
                                        <option value="tour_manager" {{ $usr->role === 'tour_manager' ? 'selected' : '' }}>Tour Manager</option>
                                        <option value="hotel_partner" {{ $usr->role === 'hotel_partner' ? 'selected' : '' }}>Hotel Partner</option>
                                        <option value="admin" {{ $usr->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                                    </select>
                                @else
                                    <span class="text-[10px] text-slate-500 italic">Self (Admin)</span>
                                @endif
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
