<x-app-layout>
    <x-slot name="header">
        Edit Room Type: {{ $room->room_type }}
    </x-slot>

    <div class="max-w-3xl mx-auto glass-card p-8 rounded-2xl border border-slate-800">
        <form action="{{ route('hotels.rooms.update', $room->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Room Type -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Room Type / Title</label>
                    <input type="text" name="room_type" required placeholder="e.g. Deluxe Suite" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('room_type', $room->room_type) }}">
                    @error('room_type') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Price per Night -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Price per Night (₹)</label>
                    <input type="number" name="price_per_night" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('price_per_night', $room->price_per_night) }}">
                    @error('price_per_night') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Capacity -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Max Capacity</label>
                    <input type="number" name="capacity" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('capacity', $room->capacity) }}">
                    @error('capacity') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Image URL -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Room Image URL</label>
                    <input type="url" name="image_url" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('image_url', $room->image_url) }}">
                    @error('image_url') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Amenities -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Amenities (Comma separated)</label>
                    <input type="text" name="amenities" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('amenities', implode(', ', (array)$room->amenities)) }}">
                    @error('amenities') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Availability -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Availability Status</label>
                    <select name="is_available" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
                        <option value="1" {{ old('is_available', $room->is_available) == 1 ? 'selected' : '' }}>Bookable</option>
                        <option value="0" {{ old('is_available', $room->is_available) == 0 ? 'selected' : '' }}>Blocked</option>
                    </select>
                    @error('is_available') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center space-x-4 border-t border-slate-800 pt-6">
                <button type="submit" class="flex-grow py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition">
                    Save Changes
                </button>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-slate-900 border border-slate-800 text-slate-300 hover:bg-slate-800 rounded-xl text-sm transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
