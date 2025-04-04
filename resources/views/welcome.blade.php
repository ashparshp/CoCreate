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
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full bg-gray-50 dark:bg-secondary-900" x-data="{
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
        <div class="min-h-screen">
            <div class="relative isolate px-6 pt-14 lg:px-8">
                <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-primary-200 to-primary-600 opacity-30 dark:opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
                </div>
                
                <nav class="flex items-center justify-between pt-6">
                    <div class="flex lg:flex-1">
                        <a href="#" class="-m-1.5 p-1.5 flex items-center">
                            <x-application-logo class="h-10 w-10 text-primary-600 dark:text-primary-400" />
                            <h1 class="ml-2 text-2xl font-bold text-primary-600 dark:text-primary-400">Student Project Portal</h1>
                        </a>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Dark mode toggle -->
                        <button 
                            @click="darkMode = !darkMode; darkMode ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark'); localStorage.setItem('darkMode', darkMode)" 
                            type="button" 
                            class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer bg-secondary-200 dark:bg-secondary-700 w-11 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                            :class="darkMode ? 'bg-secondary-700' : 'bg-secondary-200'"
                        >
                            <span class="sr-only">Toggle dark mode</span>
                            <span 
                                aria-hidden="true" 
                                class="relative inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 rounded-full shadow pointer-events-none bg-white dark:bg-secondary-900 ring-0"
                                :class="darkMode ? 'translate-x-5' : 'translate-x-0'"
                            >
                                <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" 
                                    :class="darkMode ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'">
                                    <!-- Sun icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity" 
                                    :class="darkMode ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100'">
                                    <!-- Moon icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-indigo-200" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                                    </svg>
                                </span>
                            </span>
                        </button>
                        
                        @if (Route::has('login'))
                            <div>
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-primary-600 dark:border-primary-400 text-sm font-medium rounded-md text-primary-600 dark:text-primary-400 bg-transparent hover:bg-primary-600 hover:text-white dark:hover:bg-primary-600 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 transition-colors duration-200 mr-2">Log in</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn-primary">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </nav>
                
                <div class="mx-auto max-w-7xl py-24 sm:py-32 lg:py-40">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-secondary-900 dark:text-white sm:text-6xl">Collaborate on College Projects with Ease</h1>
                        <p class="mt-6 text-lg leading-8 text-secondary-600 dark:text-secondary-300">Find teammates, manage tasks, share files, and communicate in one place. The ultimate collaboration tool designed for college students.</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-primary text-base py-3 px-6">Go to Dashboard</a>
                            @else
                                <a href="{{ route('register') }}" class="btn-primary text-base py-3 px-6">Get Started</a>
                                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-secondary-900 dark:text-secondary-100 flex items-center">Log In <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="mx-auto max-w-7xl px-6 lg:px-8 pb-24">
                    <div class="mx-auto max-w-2xl lg:text-center">
                        <h2 class="text-base font-semibold leading-7 text-primary-600 dark:text-primary-400">Better Together</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-secondary-900 dark:text-white sm:text-4xl">Everything you need for successful projects</p>
                        <p class="mt-6 text-lg leading-8 text-secondary-600 dark:text-secondary-300">Our platform provides all the tools you need to collaborate effectively on college projects, from planning and team formation to execution and delivery.</p>
                    </div>
                    <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-secondary-900 dark:text-white">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary-600 dark:bg-primary-700">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    Find the Perfect Team
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-secondary-600 dark:text-secondary-400">Match with classmates based on skills, interests, and availability. Build a balanced team with complementary strengths.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-secondary-900 dark:text-white">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary-600 dark:bg-primary-700">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                    </div>
                                    Organize Tasks Efficiently
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-secondary-600 dark:text-secondary-400">Create, assign, and track tasks with our intuitive kanban board. Keep everyone on the same page and meet deadlines.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-secondary-900 dark:text-white">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary-600 dark:bg-primary-700">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                    </div>
                                    Seamless File Sharing
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-secondary-600 dark:text-secondary-400">Upload, organize, and access project files in one central location. No more hunting through emails for the latest version.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-secondary-900 dark:text-white">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary-600 dark:bg-primary-700">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                    </div>
                                    Real-time Communication
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-secondary-600 dark:text-secondary-400">Chat with your team, comment on tasks, and keep discussions organized by project. Never miss an important update.</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                
                <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                    <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-primary-200 to-primary-600 opacity-30 dark:opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"></div>
                </div>
            </div>
            
            <footer class="bg-white dark:bg-secondary-800 border-t border-secondary-200 dark:border-secondary-700">
                <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
                    <div class="flex justify-center space-x-6 md:order-2">
                        <a href="#" class="text-secondary-400 dark:text-secondary-500 hover:text-secondary-500 dark:hover:text-secondary-400">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <div class="mt-8 md:order-1 md:mt-0">
                        <p class="text-center text-xs leading-5 text-secondary-500 dark:text-secondary-400">&copy; {{ date('Y') }} Student Project Collaboration Portal. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
