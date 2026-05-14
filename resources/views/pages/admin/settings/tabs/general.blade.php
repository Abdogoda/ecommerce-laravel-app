<!-- General Settings Tab -->
<div id="generalTab" class="tab-content">
    <h3 class="text-xl font-bold text-white mb-6">General Settings</h3>

    <form action="{{ route('admin.settings.updateGeneral') }}" method="POST" enctype="multipart/form-data"
        class="space-y-6">
        @csrf

        <!-- Store Name and Email -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="form-group">
                <label for="name" class="text-gray-400 mb-2 block">Store Name</label>
                <input type="text" id="name" name="name"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Your Store Name"
                    value="{{ isset($general) && isset($general->name) ? $general->name : '' }}" required />
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="text-gray-400 mb-2 block">Store Email</label>
                <input type="email" id="email" name="email"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="store@example.com"
                    value="{{ isset($general) && isset($general->email) ? $general->email : '' }}" required />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Phone and Address -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="form-group">
                <label for="phone" class="text-gray-400 mb-2 block">Phone Number</label>
                <input type="tel" id="phone" name="phone"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="+1 (555) 000-0000"
                    value="{{ isset($general) && isset($general->phone) ? $general->phone : '' }}" />
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="address" class="text-gray-400 mb-2 block">Store Address</label>
                <input type="text" id="address" name="address"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="123 Main Street, City, State"
                    value="{{ isset($general) && isset($general->address) ? $general->address : '' }}" />
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Currency Settings -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="form-group">
                <label for="currency" class="text-gray-400 mb-2 block">Currency</label>
                <select id="currency" name="currency"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="EGP"
                        {{ isset($general) && isset($general->currency) && $general->currency === 'EGP' ? 'selected' : '' }}>
                        EGP - Egyptian Pound</option>
                    <option value="USD"
                        {{ isset($general) && isset($general->currency) && $general->currency === 'USD' ? 'selected' : '' }}>
                        USD - US Dollar</option>
                    <option value="EUR"
                        {{ isset($general) && isset($general->currency) && $general->currency === 'EUR' ? 'selected' : '' }}>
                        EUR - Euro</option>
                    <option value="SAR"
                        {{ isset($general) && isset($general->currency) && $general->currency === 'SAR' ? 'selected' : '' }}>
                        SAR - Saudi Riyal</option>
                </select>
                @error('currency')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="currency_symbol" class="text-gray-400 mb-2 block">Currency Symbol</label>
                <input type="text" id="currency_symbol" name="currency_symbol"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="$"
                    value="{{ isset($general) && isset($general->currency_symbol) ? $general->currency_symbol : '' }}" />
                @error('currency_symbol')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="currency_position" class="text-gray-400 mb-2 block">Symbol Position</label>
                <select id="currency_position" name="currency_position"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="before"
                        {{ isset($general) && isset($general->currency_position) && $general->currency_position === 'before' ? 'selected' : '' }}>
                        Before (e.g., $100)</option>
                    <option value="after"
                        {{ isset($general) && isset($general->currency_position) && $general->currency_position === 'after' ? 'selected' : '' }}>
                        After (e.g., 100$)</option>
                </select>
                @error('currency_position')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="items_per_page" class="text-gray-400 mb-2 block">Items Per Page</label>
                <input type="number" id="items_per_page" name="items_per_page"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="25"
                    value="{{ isset($general) && isset($general->items_per_page) ? $general->items_per_page : 25 }}"
                    min="1" />
                @error('items_per_page')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Tax Settings -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <h4 class="text-lg font-semibold text-white mb-4">Tax Settings</h4>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="tax_rate" class="text-gray-400 mb-2 block">Tax Rate (%)</label>
                    <input type="number" id="tax_rate" name="tax_rate" step="0.01"
                        class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="14.00"
                        value="{{ isset($general) && isset($general->tax_rate) ? $general->tax_rate : 0 }}" />
                    @error('tax_rate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group flex items-end">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="tax_included" id="tax_included"
                            class="w-5 h-5 rounded-lg cursor-pointer focus:ring-2 focus:ring-blue-500"
                            {{ isset($general) && isset($general->tax_included) && $general->tax_included ? 'checked' : '' }} />
                        <span class="text-gray-400 ml-3">Tax is included in product prices</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Maintenance Mode -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-white mb-1">Maintenance Mode</h4>
                    <p class="text-gray-400 text-sm">Enable to temporarily close your store for maintenance</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="maintenance_mode" id="maintenance_mode" class="sr-only peer"
                        {{ isset($general) && isset($general->maintenance_mode) && $general->maintenance_mode ? 'checked' : '' }} />
                    <div
                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>
        </div>

        <!-- Logo and Favicon Upload -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <h4 class="text-lg font-semibold text-white mb-4">Branding</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="logo" class="text-gray-400 mb-2 block">Store Logo</label>
                    @if (isset($general) && !empty($general->logo))
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $general->logo) }}" alt="Store Logo"
                                class="h-10 w-10 rounded-lg border border-white/10 bg-white/5 p-1" />
                        </div>
                    @endif
                    <input type="file" id="logo" name="logo"
                        class="form-input w-full px-4 py-3 glass rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="favicon" class="text-gray-400 mb-2 block">Favicon</label>
                    @if (isset($general) && !empty($general->favicon))
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $general->favicon) }}" alt="Favicon"
                                class="h-10 w-10 rounded-lg border border-white/10 bg-white/5 p-1" />
                        </div>
                    @endif
                    <input type="file" id="favicon" name="favicon"
                        class="form-input w-full px-4 py-3 glass rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    @error('favicon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-4">
            <button type="submit"
                class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save General Settings
            </button>
        </div>
    </form>
</div>
