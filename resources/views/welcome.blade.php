<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Student Project Portal') }}</title>

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Custom Animation Styles -->
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
      animation: fadeIn 0.8s ease-out forwards;
    }
  </style>
</head>
<body class="font-sans antialiased h-full bg-gradient-to-br from-indigo-100 via-purple-200 to-indigo-300 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900" 
      x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        init() {
          if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            this.darkMode = true;
          } else {
            document.documentElement.classList.remove('dark');
            this.darkMode = false;
          }
        }
      }" x-init="init()">
  <div class="min-h-screen flex flex-col">
    <!-- Nav Bar with Separate Background -->
    <header class="bg-white dark:bg-gray-800 shadow-md">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 fade-in">
        <nav class="flex items-center justify-between">
          <a href="#" class="flex items-center group transition-colors duration-200">
            <img src="{{ asset('cocreate-logo.svg') }}" 
                 class="h-10 w-10 text-blue-600 dark:text-blue-400 transition-colors duration-200 group-hover:text-blue-700 dark:group-hover:text-blue-300" 
                 alt="CoCreate Logo">
            <h1 class="ml-3 text-xl font-bold text-gray-900 dark:text-white transition-colors duration-200 group-hover:text-blue-700 dark:group-hover:text-blue-300">
              CoCreate
            </h1>
          </a>
          <div class="flex items-center gap-5">
            <!-- Updated Dark Mode Toggle with Provided SVG -->
            <button 
              @click="darkMode = !darkMode; darkMode ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark'); localStorage.setItem('darkMode', darkMode)" 
              type="button" 
              class="p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" 
                   :class="darkMode ? 'text-indigo-300' : 'text-yellow-500'"
                   fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      :d="darkMode 
                          ? 'M12 3v1m0 16v1m8-8h1M3 12H2m15.364 6.364l.707.707M6.343 6.343l-.707-.707m0 12.728l.707.707M17.657 6.343l-.707-.707' 
                          : 'M12 3a9 9 0 000 18 9 9 0 010-18z'" />
              </svg>
            </button>
            @if (Route::has('login'))
              <div class="flex items-center">
                @auth
                  <a href="{{ url('/dashboard') }}" 
                     class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Dashboard
                  </a>
                @else
                  <a href="{{ route('login') }}" 
                     class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 focus:outline-none transition-colors duration-200">
                    Log in
                  </a>
                  @if (Route::has('register'))
                    <a href="{{ route('register') }}" 
                       class="ml-4 inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                      Register
                    </a>
                  @endif
                @endauth
              </div>
            @endif
          </div>
        </nav>
      </div>
    </header>
    
    <!-- Main Content -->
    <main class="flex-grow">
      <!-- Hero Section with Fade-in -->
      <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 fade-in" style="animation-delay: 0.2s;">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight tracking-tight transition-colors duration-300">
            Collaborate on College Projects with Ease
          </h1>
          <div class="relative mt-12 mx-auto max-w-2xl px-6 py-5 bg-white/80 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 backdrop-blur-md rounded-2xl shadow-md transition-shadow duration-300 hover:shadow-lg">
            <p class="text-center text-lg sm:text-xl font-medium text-gray-800 dark:text-gray-200 leading-relaxed">
              Find teammates, manage tasks, share files, and communicate — all in one place.<br />
              <span class="text-blue-600 dark:text-blue-400 font-semibold">
                Built for students. Designed for collaboration.
              </span>
            </p>
          </div>
          <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            @auth
              <a href="{{ url('/dashboard') }}" 
                 class="w-full sm:w-auto px-8 py-3 text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Go to Dashboard
              </a>
            @else
              <a href="{{ route('register') }}" 
                 class="w-full sm:w-auto px-8 py-3 text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Get Started
              </a>
              <a href="{{ route('login') }}" 
                 class="w-full sm:w-auto mt-2 sm:mt-0 px-8 py-3 text-base font-medium text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl shadow-sm transition-colors duration-200">
                Log In
              </a>
            @endauth
          </div>
        </div>
      </section>
      
      <!-- Features Section with Fade-in -->
      <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-20 bg-white dark:bg-gray-800 rounded-3xl shadow-xl fade-in" style="animation-delay: 0.4s;">
        <div class="max-w-3xl mx-auto text-center mb-16">
          <span class="inline-block text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
            Better Together
          </span>
          <h2 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
            Everything You Need for Successful Projects
          </h2>
          <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
            All-in-one platform from planning to delivery — create teams, assign tasks, share files, and communicate effortlessly.
          </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-14 max-w-5xl mx-auto">
          <!-- Feature Card 1 -->
          <div class="relative group transition-shadow duration-200 hover:shadow-lg">
            <div class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <div class="pl-16">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Find the Perfect Team</h3>
              <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                Match with classmates based on skills, interests, and availability. Build well-rounded teams for any project.
              </p>
            </div>
          </div>
          <!-- Feature Card 2 -->
          <div class="relative group transition-shadow duration-200 hover:shadow-lg">
            <div class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
              </svg>
            </div>
            <div class="pl-16">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Organize Tasks Efficiently</h3>
              <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                Use a visual kanban board to manage tasks, deadlines, and responsibilities in one place.
              </p>
            </div>
          </div>
          <!-- Feature Card 3 -->
          <div class="relative group transition-shadow duration-200 hover:shadow-lg">
            <div class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
              </svg>
            </div>
            <div class="pl-16">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Seamless File Sharing</h3>
              <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                Keep all project assets organized and accessible with centralized file storage and versioning.
              </p>
            </div>
          </div>
          <!-- Feature Card 4 -->
          <div class="relative group transition-shadow duration-200 hover:shadow-lg">
            <div class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
              </svg>
            </div>
            <div class="pl-16">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Real-time Communication</h3>
              <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                Chat, comment, and collaborate in real time with your project team. Stay aligned and informed.
              </p>
            </div>
          </div>
        </div>
      </section>
    </main>
    
    <!-- Footer with Fade-in -->
    <footer class="mt-24 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 fade-in" style="animation-delay: 0.6s;">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row items-center justify-between">
          <div class="flex items-center mb-4 md:mb-0">
            <svg viewBox="0 0 50 50" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M25 2C12.3 2 2 12.3 2 25s10.3 23 23 23 23-10.3 23-23S37.7 2 25 2zm0 4c10.5 0 19 8.5 19 19s-8.5 19-19 19S6 35.5 6 25 14.5 6 25 6z" />
              <path d="M35 20H15v-6h20v6zm-16 2h12v12H19V22z" />
              <path d="M32 30h-4v4h4v-4zm-9-6h-4v4h4v-4z" />
            </svg>
            <span class="ml-2 text-sm font-medium text-gray-600 dark:text-gray-400">CoCreate</span>
          </div>
          <div class="flex space-x-6">
            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
              <span class="sr-only">GitHub</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" 
                      d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" 
                      clip-rule="evenodd" />
              </svg>
            </a>
          </div>
        </div>
        <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-4">
          <p class="text-center text-xs text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} CoCreate. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</body>
</html>
