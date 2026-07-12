<x-app-layout>
    <x-slot name="header">
        Tour Management Workspace
    </x-slot>

    <!-- Stat Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 animate-slide-in">
        <div class="glass-card p-6 rounded-2xl border-l-4 border-indigo-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Total Sales Revenue</span>
            <h3 class="text-3xl font-black text-white">₹{{ number_format($revenue, 2) }}</h3>
            <p class="text-xs text-slate-500 mt-2">Earned from confirmed and paid tours</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 border-purple-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Active Tour Packages</span>
            <h3 class="text-3xl font-black text-white">{{ $packages->count() }}</h3>
            <p class="text-xs text-slate-500 mt-2">Active tour listings on the platform</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 border-emerald-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Received Bookings</span>
            <h3 class="text-3xl font-black text-white">{{ $bookings->count() }}</h3>
            <p class="text-xs text-slate-500 mt-2">Total travelers registered across packages</p>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-white">My Managed Packages</h2>
        <a href="{{ route('tours.create') }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition shadow-lg hover:shadow-indigo-500/20">
            + Create Tour Package
        </a>
    </div>

    <!-- Packages Table -->
    <div class="glass-card rounded-2xl overflow-hidden mb-12 border border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 border-b border-slate-800 text-xs font-mono uppercase text-slate-400">
                        <th class="py-4 px-6">Package details</th>
                        <th class="py-4 px-6">Destination</th>
                        <th class="py-4 px-6">Price</th>
                        <th class="py-4 px-6">Available Slots</th>
                        <th class="py-4 px-6">Start Date</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-slate-300 text-sm">
                    @forelse($packages as $pkg)
                        <tr class="hover:bg-slate-900/30 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $pkg->image_url }}" class="w-12 h-8 rounded object-cover border border-slate-800" alt="pkg image">
                                    <div>
                                        <span class="font-bold text-white block">{{ $pkg->name }}</span>
                                        <span class="text-xs text-slate-500 font-mono">{{ $pkg->duration_days }} Days</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-mono text-xs">
                                {{ $pkg->destination->name }}, {{ $pkg->destination->location }}
                            </td>
                            <td class="py-4 px-6 font-bold text-white">
                                ₹{{ number_format($pkg->price, 2) }}
                            </td>
                            <td class="py-4 px-6 font-mono text-xs">
                                {{ $pkg->available_slots }} / {{ $pkg->max_slots }} left
                            </td>
                            <td class="py-4 px-6 font-mono text-xs">
                                {{ $pkg->start_date->format('M d, Y') }}
                            </td>
                            <td class="py-4 px-6">
                                @if($pkg->status === 'active')
                                    <span class="text-[10px] px-2 py-0.5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-full font-bold uppercase">Active</span>
                                @else
                                    <span class="text-[10px] px-2 py-0.5 bg-slate-800 border border-slate-700 text-slate-400 rounded-full font-bold uppercase">Inactive</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('tours.edit', $pkg->id) }}" class="p-1.5 bg-slate-800 hover:bg-slate-700 text-indigo-300 rounded transition text-xs font-bold">
                                        Edit
                                    </a>
                                    <form action="{{ route('tours.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-950/20 hover:bg-red-600 border border-red-500/30 text-red-400 hover:text-white rounded transition text-xs font-bold">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-500">
                                You have not listed any tour packages yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bookings Table -->
    <h2 class="text-2xl font-bold text-white mb-6">Recent Tour Registrations</h2>
    <div class="glass-card rounded-2xl overflow-hidden border border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 border-b border-slate-800 text-xs font-mono uppercase text-slate-400">
                        <th class="py-4 px-6">Booking ID</th>
                        <th class="py-4 px-6">Traveler</th>
                        <th class="py-4 px-6">Package</th>
                        <th class="py-4 px-6">Paid Price</th>
                        <th class="py-4 px-6">Payment Status</th>
                        <th class="py-4 px-6">Booking Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-slate-300 text-sm">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-900/30 transition">
                            <td class="py-4 px-6 font-mono text-xs">
                                #GLB-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white">{{ $booking->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $booking->user->email }}</div>
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-300">
                                {{ $booking->bookable->name ?? 'N/A' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-white">
                                ₹{{ number_format($booking->total_price, 2) }}
                            </td>
                            <td class="py-4 px-6">
                                @if($booking->payment_status === 'paid')
                                    <span class="text-[10px] px-2 py-0.5 bg-emerald-500/10 text-emerald-400 rounded border border-emerald-500/20 font-bold uppercase">Paid</span>
                                @elseif($booking->payment_status === 'refunded')
                                    <span class="text-[10px] px-2 py-0.5 bg-red-500/10 text-red-400 rounded border border-red-500/20 font-bold uppercase">Refunded</span>
                                @else
                                    <span class="text-[10px] px-2 py-0.5 bg-amber-500/10 text-amber-400 rounded border border-amber-500/20 font-bold uppercase">Pending</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($booking->status === 'confirmed')
                                    <span class="text-[10px] px-2 py-0.5 bg-emerald-500/10 text-emerald-400 rounded font-bold uppercase border border-emerald-500/20">Confirmed</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="text-[10px] px-2 py-0.5 bg-red-500/10 text-red-400 rounded font-bold uppercase border border-red-500/20">Cancelled</span>
                                @else
                                    <span class="text-[10px] px-2 py-0.5 bg-amber-500/10 text-amber-400 rounded font-bold uppercase border border-amber-500/20">{{ $booking->status }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <form action="{{ route('booking.status', $booking->id) }}" method="POST" class="flex items-center justify-end space-x-2">
                                    @csrf
                                    <input type="hidden" name="payment_status" value="{{ $booking->payment_status }}">
                                    <select name="status" onchange="this.form.submit()" class="bg-slate-900 border border-slate-800 text-slate-300 rounded px-2 py-1 text-xs focus:outline-none">
                                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirm</option>
                                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancel</option>
                                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Complete</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-500">
                                No travel registrations received yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
