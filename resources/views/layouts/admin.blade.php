<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CoCreate') }} - Admin</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col">
            <!-- Admin Top Navbar -->
            <nav class="bg-indigo-600 dark:bg-indigo-800 text-white shadow-lg" x-data="{ mobileMenuOpen: false }">
                <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
                    <div class="relative flex items-center justify-between h-16">
                        <!-- Logo and Menu -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                                    <x-application-logo class="h-10 w-10 text-white" />
                                    <span class="ml-2 text-xl font-bold">{{ config('app.name') }} Admin</span>
                                </a>
                            </div>
                            <div class="hidden md:block ml-10">
                                <div class="flex space-x-4">
                                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Dashboard</a>
                                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Users</a>
                                    <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Projects</a>
                                    <a href="{{ route('admin.skills.index') }}" class="{{ request()->routeIs('admin.skills.*') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Skills</a>
                                    <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Settings</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side - User Menu -->
                        <div class="flex items-center">
                            <x-dark-mode-switcher class="mr-4" />
                            
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white transition-colors duration-200">
                                    <div class="h-8 w-8 rounded-full bg-indigo-800 dark:bg-indigo-700 flex items-center justify-center text-white font-semibold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="ml-2 hidden sm:block">{{ Auth::user()->name }}</span>
                                    <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5" style="display: none;">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                        {{ __('Return to App') }}
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                        {{ __('Profile') }}
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mobile menu button -->
                        <div class="md:hidden flex">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-indigo-500 dark:hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-colors duration-200" aria-controls="mobile-menu" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>
                                <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <svg x-show="mobileMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="md:hidden" id="mobile-menu" x-show="mobileMenuOpen" style="display: none;">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">Users</a>
                        <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">Projects</a>
                        <a href="{{ route('admin.skills.index') }}" class="{{ request()->routeIs('admin.skills.*') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">Skills</a>
                        <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'bg-indigo-700 dark:bg-indigo-900' : 'hover:bg-indigo-500 dark:hover:bg-indigo-700' }} block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">Settings</a>
                    </div>
                </div>
            </nav>

            <!-- Rest of the page content remains unchanged -->
            <!-- Page Header -->
            @hasSection('header')
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                <!-- Flash Messages -->
                @if(session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </button>
                    </div>
                @endif
                
                @if(session()->has('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 shadow-inner py-4 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                        {{ config('app.name') }} &copy; {{ date('Y') }} - Admin Panel
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>