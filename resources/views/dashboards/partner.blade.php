<x-app-layout>
    <x-slot name="header">
        Hotel Partner Panel
    </x-slot>

    <!-- Stat Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 animate-slide-in">
        <div class="glass-card p-6 rounded-2xl border-l-4 border-indigo-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Accommodation Revenue</span>
            <h3 class="text-3xl font-black text-white">₹{{ number_format($revenue, 2) }}</h3>
            <p class="text-xs text-slate-500 mt-2">Earned from confirmed and paid rooms</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 border-purple-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Registered Hotels</span>
            <h3 class="text-3xl font-black text-white">{{ $hotels->count() }}</h3>
            <p class="text-xs text-slate-500 mt-2">Verified hotels listed on GlobeFly</p>
        </div>
        <div class="glass-card p-6 rounded-2xl border-l-4 border-emerald-500">
            <span class="text-xs text-slate-400 font-mono uppercase block mb-1">Room Reservations</span>
            <h3 class="text-3xl font-black text-white">{{ $bookings->count() }}</h3>
            <p class="text-xs text-slate-500 mt-2">Total customer nights booked</p>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-white">My Hotels & Accommodations</h2>
        <a href="{{ route('hotels.create') }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition shadow-lg hover:shadow-indigo-500/20">
            + Register Hotel
        </a>
    </div>

    <!-- Hotels Accordion / Details -->
    @if($hotels->isEmpty())
        <div class="glass-card p-10 text-center rounded-2xl mb-12">
            <p class="text-slate-400 mb-4">You have not registered any hotels yet.</p>
            <a href="{{ route('hotels.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-xs">
                Register Hotel Profile
            </a>
        </div>
    @else
        <div class="space-y-8 mb-12">
            @foreach($hotels as $hotel)
                <div class="glass-card rounded-2xl overflow-hidden border border-slate-800">
                    <!-- Hotel Header -->
                    <div class="bg-slate-900/80 p-6 border-b border-slate-800 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-start space-x-4">
                            <img src="{{ $hotel->image_url }}" class="w-20 h-14 rounded-lg object-cover border border-slate-800" alt="hotel img">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-xl font-bold text-white">{{ $hotel->name }}</h3>
                                    <div class="flex text-amber-400 text-xs">
                                        @for($i = 0; $i < $hotel->star_rating; $i++)
                                            ★
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-xs text-slate-400 font-mono mt-1">{{ $hotel->location }} — {{ $hotel->address }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <a href="{{ route('hotels.rooms.create', $hotel->id) }}" class="px-3 py-1.5 bg-emerald-600/10 border border-emerald-500/20 hover:bg-emerald-600 text-emerald-300 hover:text-white rounded-lg text-xs font-bold transition">
                                + Add Room Type
                            </a>
                            <a href="{{ route('hotels.edit', $hotel->id) }}" class="px-3 py-1.5 bg-slate-850 hover:bg-slate-800 border border-slate-700 text-slate-300 rounded-lg text-xs font-bold transition">
                                Edit Hotel
                            </a>
                            <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this hotel?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-950/20 hover:bg-red-650 border border-red-500/30 text-red-400 hover:text-white rounded-lg text-xs font-bold transition">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Hotel Rooms Table -->
                    <div class="p-6">
                        <h4 class="text-sm font-bold font-mono text-slate-400 uppercase tracking-wider mb-4">Available Room Types</h4>
                        @if($hotel->rooms->isEmpty())
                            <p class="text-slate-500 text-xs italic">No rooms have been added to this hotel. Click "+ Add Room Type" above to configure lodging options.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($hotel->rooms as $room)
                                    <div class="glass-card-light p-4 rounded-xl border border-slate-900/60 flex flex-col justify-between">
                                        <div>
                                            <img src="{{ $room->image_url }}" class="w-full h-32 rounded-lg object-cover mb-4 border border-slate-800" alt="room img">
                                            <div class="flex items-start justify-between">
                                                <h5 class="font-bold text-white text-base">{{ $room->room_type }}</h5>
                                                <span class="text-[10px] px-2 py-0.5 bg-slate-800 text-slate-400 rounded-full font-mono font-bold">
                                                    Cap: {{ $room->capacity }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-indigo-400 font-bold mt-1 font-mono">₹{{ number_format($room->price_per_night, 2) }} / Night</p>
                                            
                                            <!-- Amenities -->
                                            <div class="mt-3 flex flex-wrap gap-1">
                                                @foreach((array)$room->amenities as $am)
                                                    <span class="text-[9px] bg-slate-900/80 px-1.5 py-0.5 rounded text-slate-400 font-mono">{{ $am }}</span>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-3 border-t border-slate-850 flex items-center justify-between">
                                            <span class="text-xs font-mono">
                                                Status: 
                                                <strong class="{{ $room->is_available ? 'text-emerald-400' : 'text-red-400' }}">
                                                    {{ $room->is_available ? 'Bookable' : 'Blocked' }}
                                                </strong>
                                            </span>
                                            <div class="flex items-center space-x-1.5">
                                                <a href="{{ route('hotels.rooms.edit', $room->id) }}" class="px-2 py-1 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-bold">
                                                    Edit
                                                </a>
                                                <form action="{{ route('hotels.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Remove this room type?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 bg-red-950/20 text-red-400 hover:bg-red-650 hover:text-white rounded text-[11px] font-bold">
                                                        🗑
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Hotel Bookings Table -->
    <h2 class="text-2xl font-bold text-white mb-6">Recent Hotel Reservations</h2>
    <div class="glass-card rounded-2xl overflow-hidden border border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 border-b border-slate-800 text-xs font-mono uppercase text-slate-400">
                        <th class="py-4 px-6">Reservation ID</th>
                        <th class="py-4 px-6">Guest Details</th>
                        <th class="py-4 px-6">Hotel / Room</th>
                        <th class="py-4 px-6">Dates</th>
                        <th class="py-4 px-6">Total Price</th>
                        <th class="py-4 px-6">Booking Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-slate-300 text-sm">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-900/30 transition">
                            <td class="py-4 px-6 font-mono text-xs">
                                #RES-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white">{{ $booking->user->name }}</div>
                                <div class="text-xs text-slate-500 font-mono">{{ $booking->user->phone }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white">{{ $booking->bookable->hotel->name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $booking->bookable->room_type ?? 'N/A' }}</div>
                            </td>
                            <td class="py-4 px-6 font-mono text-xs">
                                {{ $booking->start_date->format('M d, Y') }} 
                                @if($booking->end_date)
                                    - {{ $booking->end_date->format('M d, Y') }}
                                @endif
                            </td>
                            <td class="py-4 px-6 font-bold text-white">
                                ₹{{ number_format($booking->total_price, 2) }}
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
                                <form action="{{ route('partner.booking.status', $booking->id) }}" method="POST" class="flex items-center justify-end space-x-2">
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
                                No reservations received yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
