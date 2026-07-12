<x-app-layout>
    <x-slot name="title">Booking Ticket Receipt - GlobeFly Adventures</x-slot>

    <div class="max-w-2xl mx-auto animate-slide-in">
        
        <!-- Ticket Boarding Pass -->
        <div class="glass-card rounded-3xl overflow-hidden border border-slate-800 shadow-2xl relative">
            
            <!-- Ticket Header -->
            <div class="bg-gradient-brand px-8 py-6 flex items-center justify-between text-white relative">
                <div>
                    <span class="text-xs uppercase tracking-widest opacity-80 font-mono">GlobeFly Boarding Pass</span>
                    <h2 class="text-2xl font-black mt-1">Travel Voucher</h2>
                </div>
                <div class="text-right">
                    <span class="text-xs font-mono uppercase bg-slate-950/40 px-2 py-0.5 rounded border border-white/20">
                        {{ str_replace('App\\Models\\', '', $booking->bookable_type) }}
                    </span>
                    <p class="text-sm font-mono font-bold mt-2">#GLB-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Ticket Body -->
            <div class="p-8 space-y-6 bg-slate-900/50">
                <!-- Traveler & Status -->
                <div class="grid grid-cols-2 gap-4 pb-6 border-b border-slate-800/80">
                    <div>
                        <span class="text-xs text-slate-500 font-mono uppercase block">Passenger Name</span>
                        <span class="font-bold text-white text-base">{{ $booking->user->name }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-500 font-mono uppercase block">Booking Status</span>
                        <span class="inline-block text-xs font-bold font-mono text-emerald-400 px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20 uppercase mt-1">
                            {{ $booking->status }} / {{ $booking->payment_status }}
                        </span>
                    </div>
                </div>

                <!-- Product Detail -->
                <div class="pb-6 border-b border-slate-800/80">
                    <span class="text-xs text-slate-500 font-mono uppercase block">Reserved Service</span>
                    <h3 class="text-xl font-bold text-white mt-1">
                        {{ $booking->bookable->name ?? $booking->bookable->room_type ?? 'N/A' }}
                    </h3>
                    @if(isset($booking->bookable->hotel))
                        <span class="text-xs text-indigo-400 font-mono block mt-1">{{ $booking->bookable->hotel->name }}</span>
                    @endif
                </div>

                <!-- Dates & Times -->
                <div class="grid grid-cols-2 gap-4 pb-6 border-b border-slate-800/80 font-mono text-xs">
                    <div>
                        <span class="text-xs text-slate-500 uppercase block font-sans">Start Date</span>
                        <span class="font-bold text-white text-sm block mt-1">{{ $booking->start_date->format('l, M d, Y') }}</span>
                    </div>
                    <div class="text-right">
                        @if($booking->end_date)
                            <span class="text-xs text-slate-500 uppercase block font-sans">End Date</span>
                            <span class="font-bold text-white text-sm block mt-1">{{ $booking->end_date->format('l, M d, Y') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Costs & Details -->
                <div class="flex items-center justify-between pb-6 border-b border-slate-800/80">
                    <div>
                        <span class="text-xs text-slate-500 font-mono uppercase block">Payment Method</span>
                        <span class="font-bold text-white text-sm">{{ $booking->payment_method ?? 'Credit Card' }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-500 font-mono uppercase block">Total Settled</span>
                        <span class="text-2xl font-black text-indigo-400 font-mono">₹{{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>

                <!-- Special Requests -->
                @if($booking->special_requests)
                    <div class="p-4 bg-slate-950/50 border border-slate-850 rounded-xl">
                        <span class="text-xs text-slate-500 font-mono uppercase block mb-1">Special Requests</span>
                        <p class="text-xs text-slate-300 leading-relaxed italic">"{{ $booking->special_requests }}"</p>
                    </div>
                @endif

                <!-- Mock Barcode -->
                <div class="pt-6 text-center">
                    <div class="inline-block p-4 bg-white rounded-xl mb-2 shadow-inner">
                        <!-- Barcode bars using CSS flex -->
                        <div class="flex items-end justify-center h-14 w-64 space-x-0.5 bg-white">
                            @for($b = 0; $b < 32; $b++)
                                @php
                                    $w = rand(1, 4);
                                    $h = rand(85, 100);
                                @endphp
                                <div class="bg-black" style="width: {{ $w }}px; height: {{ $h }}%;"></div>
                            @endfor
                        </div>
                    </div>
                    <p class="text-[10px] font-mono text-slate-500 tracking-widest uppercase">
                        Voucher-Code: GLB-{{ $booking->id }}-{{ mt_rand(1000, 9999) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Action buttons below ticket -->
        <div class="mt-8 flex items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}" class="flex-grow py-3 bg-slate-900 border border-slate-800 hover:bg-slate-850 text-slate-200 text-sm font-bold rounded-xl text-center transition">
                Return to Dashboard
            </a>

            @if($booking->status === 'confirmed')
                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Cancel this booking and claim a full refund?')" class="flex-grow">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-red-950/20 border border-red-500/30 text-red-400 hover:bg-red-650 hover:text-white text-sm font-bold rounded-xl text-center transition">
                        Cancel & Refund Ticket
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
