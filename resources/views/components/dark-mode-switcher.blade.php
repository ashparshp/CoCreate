<button
    onclick="toggleDarkMode()"
    type="button" 
    {{ $attributes->merge(['class' => 'relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer bg-secondary-200 dark:bg-secondary-700 w-11 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-secondary-800']) }}
    aria-label="Toggle Dark Mode"
>
    <span class="sr-only">Toggle dark mode</span>
    <span 
        aria-hidden="true" 
        class="relative inline-block w-5 h-5 transition duration-200 ease-in-out transform rounded-full shadow pointer-events-none bg-white dark:bg-secondary-900 ring-0 translate-x-0 dark:translate-x-5"
    >
        <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity opacity-100 ease-in duration-200 dark:opacity-0">
            <!-- Sun icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
            </svg>
        </span>
        <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity opacity-0 ease-out duration-100 dark:opacity-100 dark:ease-in dark:duration-200">
            <!-- Moon icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-indigo-200" viewBox="0 0 20 20" fill="currentColor">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
            </svg>
        </span>
    </span>
</button>