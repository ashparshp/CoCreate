@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('System Settings') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Application Settings') }}</h3>
                </div>
                
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 space-y-6">
                        <!-- App Name -->
                        <div>
                            <label for="app_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Application Name') }}
                            </label>
                            <input type="text" name="app_name" id="app_name" value="{{ config('app.name', 'CoCreate') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200">
                            @error('app_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Primary Color -->
                        <div>
                            <label for="primary_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Primary Color') }}
                            </label>
                            <div class="flex items-center mt-1">
                                <input type="color" name="primary_color" id="primary_color" value="#4f46e5"
                                    class="h-10 rounded-l-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200">
                                <input type="text" name="primary_color_hex" id="primary_color_hex" value="#4f46e5"
                                    class="h-10 w-full rounded-r-md border-l-0 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200" 
                                    readonly>
                            </div>
                            @error('primary_color')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- User Registration -->
                        <div class="flex items-center">
                            <input type="checkbox" name="enable_user_registration" id="enable_user_registration" value="1" checked
                                   class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-colors duration-200">
                            <label for="enable_user_registration" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                {{ __('Enable User Registration') }}
                            </label>
                        </div>

                        <!-- Email Verification -->
                        <div class="flex items-center">
                            <input type="checkbox" name="enable_email_verification" id="enable_email_verification" value="1" checked
                                   class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-colors duration-200">
                            <label for="enable_email_verification" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                {{ __('Enable Email Verification') }}
                            </label>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700 text-right">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                            {{ __('Save Settings') }}
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Cache Management Section -->
            <div class="mt-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Cache Management') }}</h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ __('Clear application caches to apply configuration changes.') }}
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to clear the application cache?')) { /* Add AJAX call here */ }" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                            {{ __('Clear Config Cache') }}
                        </a>
                        
                        <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to clear the route cache?')) { /* Add AJAX call here */ }" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                            {{ __('Clear Route Cache') }}
                        </a>
                        
                        <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to clear the view cache?')) { /* Add AJAX call here */ }" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                            {{ __('Clear View Cache') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update hex input when color picker changes
        document.addEventListener('DOMContentLoaded', function() {
            const colorPicker = document.getElementById('primary_color');
            const hexInput = document.getElementById('primary_color_hex');
            
            colorPicker.addEventListener('input', function() {
                hexInput.value = colorPicker.value;
            });
        });
    </script>
@endsection