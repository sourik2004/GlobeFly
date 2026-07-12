<x-app-layout>
    <x-slot name="header">
        Edit Hotel Property: {{ $hotel->name }}
    </x-slot>

    <div class="max-w-3xl mx-auto glass-card p-8 rounded-2xl border border-slate-800">
        <form action="{{ route('hotels.update', $hotel->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Hotel Name</label>
                <input type="text" name="name" required placeholder="e.g. Grand Palace Hotel" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('name', $hotel->name) }}">
                @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">{{ old('description', $hotel->description) }}</textarea>
                @error('description') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Location -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">City & Country</label>
                    <input type="text" name="location" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('location', $hotel->location) }}">
                    @error('location') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Star Rating -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Star Rating</label>
                    <select name="star_rating" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
                        <option value="3" {{ old('star_rating', $hotel->star_rating) == 3 ? 'selected' : '' }}>3 Stars</option>
                        <option value="4" {{ old('star_rating', $hotel->star_rating) == 4 ? 'selected' : '' }}>4 Stars</option>
                        <option value="5" {{ old('star_rating', $hotel->star_rating) == 5 ? 'selected' : '' }}>5 Stars (Luxury)</option>
                    </select>
                    @error('star_rating') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Full Street Address</label>
                <input type="text" name="address" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('address', $hotel->address) }}">
                @error('address') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Image URL -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Cover Image URL</label>
                <input type="url" name="image_url" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('image_url', $hotel->image_url) }}">
                @error('image_url') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
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
