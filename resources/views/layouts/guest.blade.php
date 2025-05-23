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
    <script>
      function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', document.documentElement.classList.contains('dark') ? 'true' : 'false');
      }

      if (
        localStorage.getItem('darkMode') === 'true' ||
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)
      ) {
        document.documentElement.classList.add('dark');
      }
    </script>
  </head>
  <body class="font-sans antialiased h-full bg-gradient-to-br from-orange-100 to-pink-200 dark:bg-gradient-to-br dark:from-gray-600 dark:to-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center py-8">
      <div>
        <a href="/" class="flex items-center group transition-colors duration-200">
          <img src="{{ asset('cocreate-logo.svg') }}"
               class="h-10 w-10 text-blue-600 dark:text-blue-400 transition-colors duration-200 group-hover:text-blue-700 dark:group-hover:text-blue-300"
               alt="CoCreate Logo">
          <h1 class="ml-3 text-xl font-bold text-gray-900 dark:text-white transition-colors duration-200 group-hover:text-blue-700 dark:group-hover:text-blue-300">
            CoCreate
          </h1>
        </a>
      </div>
      <!-- Container with semi-transparent background and backdrop blur -->
      <div class="w-full sm:max-w-md mt-6 px-8 py-6 bg-white/70 dark:bg-gray-900/70 backdrop-blur-md shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
        {{ $slot }}
      </div>
      <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
        &copy; {{ date('Y') }} Student Project Collaboration Portal
      </div>
    </div>
    
    <!-- Dark Mode Toggle Button for Guest Pages -->
    <div class="fixed bottom-4 right-4">
      <button 
          onclick="toggleDarkMode()"
          class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors duration-200"
          aria-label="Toggle Dark Mode">
        <!-- Toggle SVG Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
             id="darkToggleIcon"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path id="darkTogglePath" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3a9 9 0 000 18 9 9 0 010-18z" />
        </svg>
      </button>
    </div>
    
    <script>
      const darkToggleIcon = document.getElementById('darkToggleIcon');
      const darkTogglePath = document.getElementById('darkTogglePath');
      function updateToggleIcon() {
        if(document.documentElement.classList.contains('dark')) {
          darkTogglePath.setAttribute('d', 'M12 3v1m0 16v-1m8-8h1M3 12H2m15.364 6.364l.707.707M6.343 6.343l-.707-.707m0 12.728l.707.707M17.657 6.343l-.707-.707');
          darkToggleIcon.classList.remove('text-yellow-500');
          darkToggleIcon.classList.add('text-indigo-300');
        } else {
          darkTogglePath.setAttribute('d', 'M12 3a9 9 0 000 18 9 9 0 010-18z');
          darkToggleIcon.classList.remove('text-indigo-300');
          darkToggleIcon.classList.add('text-yellow-500');
        }
      }
      updateToggleIcon();
      document.querySelector('button[onclick="toggleDarkMode()"]').addEventListener('click', () => {
        setTimeout(updateToggleIcon, 100);
      });
    </script>
  </body>
</html>
