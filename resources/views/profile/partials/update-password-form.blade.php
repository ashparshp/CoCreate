<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Current Password') }}
                </label>
                <input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-700 dark:text-white" 
                    autocomplete="current-password"
                />
                @error('current_password', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('New Password') }}
                </label>
                <input 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-700 dark:text-white" 
                    autocomplete="new-password"
                />
                @error('password', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Confirm Password') }}
                </label>
                <input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-700 dark:text-white" 
                    autocomplete="new-password"
                />
                @error('password_confirmation', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-start pt-2">
            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 mr-3"
                >{{ __('Saved.') }}</p>
            @endif
            
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-sm text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('Save Changes') }}
            </button>
        </div>
    </form>
</section>
