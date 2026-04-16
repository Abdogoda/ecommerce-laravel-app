<!-- Social Settings Tab -->
<div id="socialTab" class="tab-content hidden">
    <h3 class="text-xl font-bold text-white mb-6">Social Media Settings</h3>

    <form action="{{ route('admin.settings.updateSocial') }}" method="POST" class="space-y-6">
        @csrf

        <p class="text-gray-400 text-sm mb-6">Add your social media links to connect with your customers. Leave blank to
            hide from footer.</p>

        <!-- Facebook -->
        <div class="form-group">
            <label for="facebook" class="text-gray-400 mb-2 block flex items-center">
                <i class="fab fa-facebook text-blue-600 mr-2"></i>
                Facebook Profile
            </label>
            <input type="url" id="facebook" name="facebook"
                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="https://facebook.com/yourpage"
                value="{{ isset($social) && isset($social->facebook) ? $social->facebook : '' }}" />
            @error('facebook')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Twitter -->
        <div class="form-group">
            <label for="twitter" class="text-gray-400 mb-2 block flex items-center">
                <i class="fab fa-twitter text-sky-500 mr-2"></i>
                Twitter Profile
            </label>
            <input type="url" id="twitter" name="twitter"
                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="https://twitter.com/yourhandle"
                value="{{ isset($social) && isset($social->twitter) ? $social->twitter : '' }}" />
            @error('twitter')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Instagram -->
        <div class="form-group">
            <label for="instagram" class="text-gray-400 mb-2 block flex items-center">
                <i class="fab fa-instagram text-pink-600 mr-2"></i>
                Instagram Profile
            </label>
            <input type="url" id="instagram" name="instagram"
                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="https://instagram.com/yourprofile"
                value="{{ isset($social) && isset($social->instagram) ? $social->instagram : '' }}" />
            @error('instagram')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- TikTok -->
        <div class="form-group">
            <label for="tiktok" class="text-gray-400 mb-2 block flex items-center">
                <i class="fab fa-tiktok text-black dark:text-white mr-2"></i>
                TikTok Profile
            </label>
            <input type="url" id="tiktok" name="tiktok"
                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="https://tiktok.com/@yourprofile"
                value="{{ isset($social) && isset($social->tiktok) ? $social->tiktok : '' }}" />
            @error('tiktok')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- YouTube -->
        <div class="form-group">
            <label for="youtube" class="text-gray-400 mb-2 block flex items-center">
                <i class="fab fa-youtube text-red-600 mr-2"></i>
                YouTube Channel
            </label>
            <input type="url" id="youtube" name="youtube"
                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="https://youtube.com/@yourchannel"
                value="{{ isset($social) && isset($social->youtube) ? $social->youtube : '' }}" />
            @error('youtube')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- WhatsApp -->
        <div class="form-group">
            <label for="whatsapp" class="text-gray-400 mb-2 block flex items-center">
                <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                WhatsApp Number
            </label>
            <input type="tel" id="whatsapp" name="whatsapp"
                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="+1 (555) 000-0000 or https://wa.me/..."
                value="{{ isset($social) && isset($social->whatsapp) ? $social->whatsapp : '' }}" />
            <p class="text-gray-500 text-sm mt-2">Enter phone number (with country code) or WhatsApp link</p>
            @error('whatsapp')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Info Box -->
        <div class="bg-blue-500/10 border border-blue-500/30 p-6 rounded-xl">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-400 mt-1 mr-3"></i>
                <div>
                    <h4 class="text-sm font-semibold text-blue-400 mb-2">Social Links Format</h4>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Facebook: https://facebook.com/page-name</li>
                        <li>• Twitter: https://twitter.com/handle</li>
                        <li>• Instagram: https://instagram.com/username</li>
                        <li>• TikTok: https://tiktok.com/@username</li>
                        <li>• YouTube: https://youtube.com/@channel</li>
                        <li>• WhatsApp: +1234567890 (phone) or https://wa.me/1234567890 (link)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-4">
            <button type="submit"
                class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Social Settings
            </button>
        </div>
    </form>
</div>
