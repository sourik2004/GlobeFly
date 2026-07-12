<x-app-layout>
    <x-slot name="header">
        Edit Tour Package: {{ $package->name }}
    </x-slot>

    <div class="max-w-3xl mx-auto glass-card p-8 rounded-2xl border border-slate-800">
        <form action="{{ route('tours.update', $package->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Package Title</label>
                <input type="text" name="name" required placeholder="e.g. Majestic Kyoto Cultural Walk" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('name', $package->name) }}">
                @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Detailed Description</label>
                <textarea name="description" rows="5" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">{{ old('description', $package->description) }}</textarea>
                @error('description') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Price -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Price per Guest (₹)</label>
                    <input type="number" name="price" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('price', $package->price) }}">
                    @error('price') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Duration (Days)</label>
                    <input type="number" name="duration_days" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('duration_days', $package->duration_days) }}">
                    @error('duration_days') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Max Slots -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Max Capacity (Seats)</label>
                    <input type="number" name="max_slots" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('max_slots', $package->max_slots) }}">
                    @error('max_slots') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Destination -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Destination Region</label>
                    <select name="destination_id" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
                        @foreach($destinations as $dest)
                            <option value="{{ $dest->id }}" {{ old('destination_id', $package->destination_id) == $dest->id ? 'selected' : '' }}>{{ $dest->name }} ({{ $dest->location }})</option>
                        @endforeach
                    </select>
                    @error('destination_id') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Visibility Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm">
                        <option value="active" {{ old('status', $package->status) === 'active' ? 'selected' : '' }}>Active (Visible)</option>
                        <option value="inactive" {{ old('status', $package->status) === 'inactive' ? 'selected' : '' }}>Inactive (Hidden)</option>
                    </select>
                    @error('status') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Image URL</label>
                <input type="url" name="image_url" class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('image_url', $package->image_url) }}">
                @error('image_url') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Start Date</label>
                    <input type="date" name="start_date" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('start_date', $package->start_date->toDateString()) }}">
                    @error('start_date') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">End Date</label>
                    <input type="date" name="end_date" required class="w-full px-4 py-2.5 rounded-lg glass-input text-sm" value="{{ old('end_date', $package->end_date->toDateString()) }}">
                    @error('end_date') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
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
