<x-app-layout>
    <x-slot name="header">
        AI-Powered Trip Planner
    </x-slot>

    <div class="max-w-3xl mx-auto animate-slide-in">
        <div class="glass-card p-8 rounded-3xl border border-slate-800 shadow-2xl relative">
            <!-- Glow background overlay -->
            <div class="absolute -right-20 -top-20 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl"></div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-black text-white">Generate Your Dream Itinerary</h2>
                <p class="text-slate-400 text-xs mt-1">
                    Describe your dream destination and constraints, and our AI will draft a customized daily schedule, estimated activity costs, and sightseeing routes.
                </p>
            </div>

            <form action="{{ route('trip.generate') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Destination -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Where do you want to go?</label>
                    <input type="text" name="destination" required placeholder="e.g. Goa, Taj Mahal, Kerala, Jaipur, Ladakh" class="w-full px-4 py-3 rounded-xl glass-input text-sm">
                    <span class="text-[10px] text-slate-500 mt-1 block font-mono">Tip: Type any city or country (like Goa or Kerala) for tailored mock or live data.</span>
                    @error('destination') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Start Date -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Departure Date</label>
                        <input type="date" name="start_date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ date('Y-m-d') }}">
                        @error('start_date') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Duration (Days)</label>
                        <select name="days" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
                            @for($d = 1; $d <= 14; $d++)
                                <option value="{{ $d }}" {{ $d == 3 ? 'selected' : '' }}>{{ $d }} Day{{ $d > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                        @error('days') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Budget -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Total Budget (₹)</label>
                        <input type="number" name="budget" required min="5000" placeholder="e.g. 50000" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="45000">
                        @error('budget') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Interests -->
                <div>
                    <label class="block text-sm font-semibold text-slate-350 mb-3">Select Your Travel Interests</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $interests = [
                                'culture' => '🏛 Culture & Art',
                                'adventure' => '🌋 Adventure & Hiking',
                                'relaxation' => '🏖 Relaxation & Beach',
                                'shopping' => '🛍 Shopping & Fashion',
                                'food' => '🍜 Food & Gastronomy',
                                'history' => '🏰 Historic Sites'
                            ];
                        @endphp
                        @foreach($interests as $val => $label)
                            <label class="flex items-center space-x-3 p-3 bg-slate-900/60 border border-slate-800 rounded-xl cursor-pointer hover:bg-slate-800 hover:border-slate-700 transition">
                                <input type="checkbox" name="interests[]" value="{{ $val }}" checked class="rounded text-indigo-600 focus:ring-indigo-500 border-slate-700 bg-slate-950">
                                <span class="text-xs text-slate-200 font-medium">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('interests') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full py-4 bg-gradient-brand text-white font-extrabold rounded-xl shadow-lg hover:shadow-indigo-500/25 hover:scale-[1.01] transition duration-200 uppercase tracking-wider text-sm flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Generate AI Itinerary</span>
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
