<x-app-layout>
    @push('styles')
        <style>
            @keyframes scanner {
                0% { top: 16px; }
                50% { top: calc(100% - 18px); }
                100% { top: 16px; }
            }
            .animate-scanner {
                animation: scanner 2.5s infinite linear;
            }
        </style>
    @endpush

    <x-slot name="header">
        Secure Booking Checkout
    </x-slot>

    <div x-data="checkoutFlow()" class="relative">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Payment Form -->
            <div class="lg:col-span-2 space-y-8 animate-slide-in">
                <div class="glass-card p-8 rounded-2xl">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center space-x-3">
                        <svg class="w-6 h-6 text-indigo-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Razorpay Secure Payment Gateway</span>
                    </h3>

                    @if($isLiveRazorpay)
                        <!-- Sandbox Live Mode Banner -->
                        <div class="p-4 mb-6 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-start space-x-3">
                            <svg class="w-5 h-5 text-indigo-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-bold text-white text-xs">Secure Razorpay Sandbox Active</h4>
                                <p class="text-slate-400 text-[11px] mt-1 leading-relaxed">
                                    Complete your reservation securely via the Razorpay payment overlay. Click the payment button below to open the checkout screen.
                                </p>
                            </div>
                        </div>
                    @else
                        <!-- Simulated Mode Banner -->
                        <div class="p-4 mb-6 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-start space-x-3">
                            <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <h4 class="font-bold text-white text-xs">Razorpay Simulator Active</h4>
                                <p class="text-slate-400 text-[11px] mt-1 leading-relaxed">
                                    Razorpay credentials are not fully configured in your <code class="text-amber-300 font-mono">.env</code>. Clicking payment will open a simulated Razorpay QR Code checkout.
                                </p>
                            </div>
                        </div>
                    @endif

                    <form id="paymentForm" action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="bookable_type" value="{{ $bookableType }}">
                        <input type="hidden" name="bookable_id" value="{{ $bookableId }}">
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                        
                        <!-- Razorpay parameters -->
                        <input type="hidden" name="payment_method" value="Razorpay">
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">
                        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $razorpayOrderId }}">
                        <input type="hidden" name="razorpay_signature" id="razorpay_signature" value="">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Details -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase font-mono tracking-wider">Customer Name</label>
                                <input type="text" readonly value="{{ auth()->user()->name }}" class="w-full px-4 py-2.5 rounded-lg glass-input text-xs text-slate-300 font-bold bg-slate-950/40">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase font-mono tracking-wider">Billing Email</label>
                                <input type="email" readonly value="{{ auth()->user()->email }}" class="w-full px-4 py-2.5 rounded-lg glass-input text-xs text-slate-300 font-bold bg-slate-950/40">
                            </div>
                        </div>

                        <!-- Special Requests -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase font-mono tracking-wider">Special Requests / Notes (Optional)</label>
                            <textarea name="special_requests" rows="3" placeholder="Dietary guidelines, room preferences, check-in requirements..." class="w-full px-4 py-2.5 rounded-lg glass-input text-xs"></textarea>
                        </div>

                        <button type="button" @click="handlePaymentSubmit" class="w-full py-4 bg-gradient-brand hover:shadow-indigo-500/20 hover:shadow-lg text-white font-extrabold rounded-xl transition duration-200 text-xs tracking-wider uppercase flex items-center justify-center space-x-2">
                            <span>Pay with Razorpay</span>
                            <span class="font-mono font-black">₹{{ number_format($totalPrice, 2) }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Order Summary Ticket -->
            <div>
                <div class="glass-card rounded-2xl overflow-hidden border border-slate-800 sticky top-24">
                    <div class="p-6 bg-slate-900 border-b border-slate-800">
                        <h3 class="font-bold text-white text-lg">Booking Summary</h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="flex items-start space-x-3">
                            <img src="{{ $bookable->image_url }}" class="w-16 h-12 rounded object-cover border border-slate-800" alt="booked asset thumb">
                            <div>
                                <h4 class="font-bold text-white text-sm line-clamp-2">
                                    {{ $bookable->name ?? $bookable->room_type }}
                                </h4>
                                <span class="text-xs text-indigo-400 font-mono">
                                    @if($bookableType === \App\Models\TourPackage::class)
                                        {{ $bookable->destination->name }} Tour
                                    @elseif($bookableType === \App\Models\HotelRoom::class)
                                        {{ $bookable->hotel->name }}
                                    @else
                                        Car Rental
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-slate-800 pt-4 space-y-3 font-mono text-xs text-slate-400">
                            <div class="flex justify-between">
                                <span>Check-in Date:</span>
                                <span class="text-white font-bold">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</span>
                            </div>
                            @if($endDate)
                                <div class="flex justify-between">
                                    <span>Check-out Date:</span>
                                    <span class="text-white font-bold">{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span>Billing Duration:</span>
                                <span class="text-white font-bold">
                                    @if($bookableType === \App\Models\TourPackage::class)
                                        {{ $bookable->duration_days }} Days
                                    @else
                                        {{ $days }} Night(s)
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-slate-800 pt-4 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-slate-500 uppercase block">Total price due</span>
                                <span class="text-3xl font-black text-indigo-400 font-mono">₹{{ number_format($totalPrice, 2) }}</span>
                            </div>
                            <span class="text-[10px] px-2 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold rounded uppercase">
                                TAX INCLUDED
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Razorpay UPI QR Code Modal Overlay -->
        <div x-show="showQrModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md"
             style="display: none;">
            
            <div class="bg-slate-900 border border-slate-800 rounded-3xl w-full max-w-md overflow-hidden shadow-2xl relative">
                <!-- Header -->
                <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between text-white select-none">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-black tracking-wider flex items-center">
                            <span>Razor</span><span class="text-indigo-200">pay</span>
                        </span>
                    </div>
                    <span class="text-[10px] px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold uppercase tracking-wider">
                        TEST MODE / SANDBOX
                    </span>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-6 text-center">
                    <div>
                        <span class="text-xs text-slate-500 font-mono block uppercase">Merchant</span>
                        <h4 class="font-extrabold text-white text-sm">GlobeFly Adventures</h4>
                    </div>

                    <div>
                        <span class="text-xs text-slate-500 font-mono block uppercase">Amount to Scan</span>
                        <h3 class="text-3xl font-black text-indigo-400 font-mono mt-1">₹{{ number_format($totalPrice, 2) }}</h3>
                    </div>

                    <!-- QR Block -->
                    <div class="relative inline-block bg-white p-4 rounded-2xl shadow-inner border border-slate-700">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&color=0f172a&data={{ urlencode('upi://pay?pa=merchant@razorpay&pn=GlobeFly%20Adventures&am=' . $totalPrice . '&cu=INR') }}" 
                             alt="Razorpay UPI QR Code" class="w-44 h-44 mx-auto select-none">
                        
                        <!-- Scanner Overlay -->
                        <div class="absolute inset-x-4 top-4 bottom-4 border-2 border-indigo-500/20 pointer-events-none rounded"></div>
                        <div class="absolute inset-x-4 top-4 h-0.5 bg-indigo-500 shadow-md shadow-indigo-500/50 animate-scanner pointer-events-none"></div>
                    </div>

                    <!-- Scanning details -->
                    <div class="space-y-3">
                        <p class="text-xs text-slate-350 leading-relaxed max-w-xs mx-auto">
                            Scan the QR code using Google Pay, PhonePe, Paytm, or BHIM to simulate transaction.
                        </p>
                        <div class="flex items-center justify-center space-x-2 text-[10px] text-slate-500 font-mono">
                            <span class="inline-block w-2 h-2 rounded-full bg-indigo-500 animate-ping"></span>
                            <span>Awaiting phone verification...</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-6 bg-slate-950/60 border-t border-slate-800 flex flex-col space-y-3">
                    <button type="button" @click="confirmSimulatedPayment" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 hover:shadow-emerald-500/10 hover:shadow-lg text-white font-extrabold rounded-xl transition duration-150 text-xs uppercase tracking-wider">
                        Simulate Payment Success
                    </button>
                    <button type="button" @click="showQrModal = false" class="w-full py-2 bg-slate-900 border border-slate-850 hover:bg-slate-800 text-slate-400 hover:text-white rounded-lg transition text-xs font-bold">
                        Cancel Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            function checkoutFlow() {
                return {
                    showQrModal: false,

                    handlePaymentSubmit() {
                        @if($isLiveRazorpay)
                            // Live Razorpay Sandboxed Checkout Flow
                            const options = {
                                "key": "{{ $razorpayKeyId }}",
                                "amount": "{{ round($totalPrice * 100) }}",
                                "currency": "INR",
                                "name": "GlobeFly Adventures",
                                "description": "Booking reservation check-out",
                                "order_id": "{{ $razorpayOrderId }}",
                                "handler": function (response) {
                                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                    if (response.razorpay_order_id) {
                                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                                    }
                                    document.getElementById('paymentForm').submit();
                                },
                                "prefill": {
                                    "name": "{{ auth()->user()->name }}",
                                    "email": "{{ auth()->user()->email }}",
                                },
                                "theme": {
                                    "color": "#6366f1"
                                }
                            };
                            const rzp = new Razorpay(options);
                            rzp.on('payment.failed', function (response){
                                alert("Payment execution failed: " + response.error.description);
                            });
                            rzp.open();
                        @else
                            // If credentials are not configured, display the beautiful dummy QR code modal
                            this.showQrModal = true;
                        @endif
                    },

                    confirmSimulatedPayment() {
                        const mockPaymentId = 'pay_sim_' + Math.random().toString(36).substring(2, 15);
                        document.getElementById('razorpay_payment_id').value = mockPaymentId;
                        document.getElementById('paymentForm').submit();
                    }
                };
            }
        </script>
    @endpush
</x-app-layout>
