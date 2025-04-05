<x-guest-layout>
  <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">
    {{ __('Create Account') }}
  </h2>
  
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-4">
      <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
      <x-text-input id="name" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" 
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
      <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
    </div>

    <!-- Email Address -->
    <div class="mb-4">
      <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
      <x-text-input id="email" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" 
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
    </div>

    <!-- Password -->
    <div class="mb-4">
      <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
      <x-text-input id="password" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" 
                    type="password" name="password" required autocomplete="new-password" />
      <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
      <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
      <x-text-input id="password_confirmation" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" 
                    type="password" name="password_confirmation" required autocomplete="new-password" />
      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
    </div>

    <div class="flex items-center justify-between">
      <a class="underline text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" 
         href="{{ route('login') }}">
         {{ __('Already registered?') }}
      </a>
      <x-primary-button class="ml-4">
        {{ __('Register') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
