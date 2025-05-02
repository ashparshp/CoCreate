<x-guest-layout>
  <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">
    {{ __('Welcome back') }}
  </h2>
  
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />
  
  <!-- Error Messages - Enhanced to style the inactive account error -->
  @if(session('error'))
    <div class="mb-4 text-sm font-medium rounded-md p-4 
      {{ str_contains(session('error'), 'deactivated') ? 'text-red-700 bg-red-100 dark:text-red-300 dark:bg-red-900/30 border border-red-200 dark:border-red-800' : 'text-red-600 dark:text-red-400' }}">
      {{ session('error') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div class="mb-4">
      <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
      <x-text-input id="email" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" 
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
    </div>

    <!-- Password -->
    <div class="mb-4">
      <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
      <x-text-input id="password" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" 
                    type="password" name="password" required autocomplete="current-password" />
      <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
    </div>

    <!-- Remember Me -->
    <div class="flex items-center mb-4">
      <input id="remember_me" type="checkbox" 
             class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500" 
             name="remember">
      <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
        {{ __('Remember me') }}
      </label>
    </div>

    <div class="flex items-center justify-between">
      @if (Route::has('password.request'))
      <a class="underline text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded" 
         href="{{ route('password.request') }}">
         {{ __('Forgot your password?') }}
      </a>
      @endif

      <x-primary-button class="ml-3">
        {{ __('Log in') }}
      </x-primary-button>
    </div>
  </form>
  
  <div class="mt-6 text-center">
    <p class="text-sm text-gray-700 dark:text-gray-300">
      {{ __('Don\'t have an account?') }}
      <a href="{{ route('register') }}" 
         class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
         {{ __('Register now') }}
      </a>
    </p>
  </div>
</x-guest-layout>
