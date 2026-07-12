<x-app-layout>
    <x-slot name="header">
        Add Room Type to {{ $hotel->name }}
    </x-slot>

    <div class="max-w-3xl mx-auto glass-card p-8 rounded-2xl border border-slate-800">
        <form action="{{ route('hotels.rooms.store', $hotel->id) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Room Type -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Room Type / Title</label>
                    <input type="text" name="room_type" required placeholder="e.g. Deluxe Suite" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('room_type') }}">
                    @error('room_type') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Price per Night -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Price per Night (₹)</label>
                    <input type="number" name="price_per_night" required placeholder="e.g. 5000" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('price_per_night') }}">
                    @error('price_per_night') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Capacity -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Max Capacity (Guests)</label>
                    <input type="number" name="capacity" required placeholder="e.g. 2" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('capacity') }}">
                    @error('capacity') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Image URL -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Room Image URL</label>
                    <input type="url" name="image_url" placeholder="https://unsplash.com/..." class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('image_url') }}">
                    @error('image_url') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Amenities -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Amenities (Comma separated)</label>
                <input type="text" name="amenities" required placeholder="WiFi, AC, Smart TV, King Bed, Ocean View" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('amenities') }}">
                <span class="text-xs text-slate-500 mt-1 block font-mono">List items separated by commas.</span>
                @error('amenities') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center space-x-4 border-t border-slate-800 pt-6">
                <button type="submit" class="flex-grow py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition">
                    Publish Room Type
                </button>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-slate-900 border border-slate-800 text-slate-300 hover:bg-slate-800 rounded-xl text-sm transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
