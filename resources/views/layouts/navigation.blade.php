<!-- Dark Mode Initialization Script -->
<script>
  if (
      localStorage.getItem('darkMode') === 'true' || 
      (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
  ) {
      document.documentElement.classList.add('dark');
  } else {
      document.documentElement.classList.remove('dark');
  }
</script>

<nav x-data="{ open: false, darkMode: localStorage.getItem('darkMode') === 'true' }" class="bg-gradient-to-r from-white to-gray-50 dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-10 shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex items-center">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center">
          <a href="{{ route('dashboard') }}" class="flex items-center group">
            <img src="{{ asset('cocreate-logo.svg') }}" class="h-10 w-10 transition group-hover:text-indigo-700 dark:group-hover:text-indigo-300" alt="CoCreate Logo">
            <span class="ml-2 text-lg font-semibold text-gray-900 dark:text-white hidden sm:block transition group-hover:text-indigo-700 dark:group-hover:text-indigo-300">
              CoCreate
            </span>
          </a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden sm:flex sm:space-x-4 sm:ml-6">
          <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
            Dashboard
          </x-nav-link>
          <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('projects.index') ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
            Projects
          </x-nav-link>
          <x-nav-link :href="route('profile.show')" :active="request()->routeIs('profile.show')" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('profile.show') ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
            Profile
          </x-nav-link>
          @auth
              @if (Auth::user()->role === 'admin')
                  <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                      Admin Dashboard
                  </x-nav-link>
              @endif
          @endauth
        </div>
      </div>

      <!-- Right Side (Dark Mode Toggle & User Dropdown) -->
      <div class="hidden sm:flex sm:items-center sm:space-x-3">
        <!-- Updated Dark Mode Toggle -->
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

        <!-- User Dropdown -->
        <x-dropdown align="right" width="48" contentClasses="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg py-1">
          <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none transition bg-white dark:bg-gray-900 rounded-full">
              <div class="relative h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mr-2 text-indigo-700 dark:text-indigo-300 font-semibold text-sm overflow-hidden">
                @if (Auth::user()->profile_photo_path)
                  <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                @else
                  {{ substr(Auth::user()->name, 0, 1) }}
                @endif
              </div>
              <div class="hidden md:block">{{ Auth::user()->name }}</div>
              <div class="ml-1">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </div>
            </button>
          </x-slot>

          <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
              Settings
            </x-dropdown-link>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <x-dropdown-link :href="route('logout')"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                Log Out
              </x-dropdown-link>
            </form>
          </x-slot>
        </x-dropdown>
      </div>

      <!-- Mobile Menu Button -->
      <div class="-mr-2 flex items-center sm:hidden">
        <!-- Mobile Dark Mode Toggle -->
        <button 
          @click="darkMode = !darkMode; darkMode ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark'); localStorage.setItem('darkMode', darkMode)" 
          type="button" 
          class="p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" 
               :class="darkMode ? 'text-indigo-300' : 'text-yellow-500'"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  :d="darkMode 
                      ? 'M12 3v1m0 16v1m8-8h1M3 12H2m15.364 6.364l.707.707M6.343 6.343l-.707-.707m0 12.728l.707.707M17.657 6.343l-.707-.707' 
                      : 'M12 3a9 9 0 000 18 9 9 0 010-18z'" />
          </svg>
        </button>
        <!-- Hamburger Menu -->
        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Responsive Menu -->
  <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block pl-3 pr-4 py-2 rounded-md text-base font-medium transition {{ request()->routeIs('dashboard') ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 dark:border-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-700 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800 border-l-4 border-transparent' }}">
        Dashboard
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')" class="block pl-3 pr-4 py-2 rounded-md text-base font-medium transition {{ request()->routeIs('projects.index') ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 dark:border-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-700 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800 border-l-4 border-transparent' }}">
        Projects
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('profile.show')" :active="request()->routeIs('profile.show')" class="block pl-3 pr-4 py-2 rounded-md text-base font-medium transition {{ request()->routeIs('profile.show') ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 dark:border-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-700 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800 border-l-4 border-transparent' }}">
        Profile
      </x-responsive-nav-link>
      @auth
          @if (Auth::user()->role === 'admin')
              <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="block pl-3 pr-4 py-2 rounded-md text-base font-medium transition {{ request()->routeIs('admin.dashboard') ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 dark:border-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-700 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800 border-l-4 border-transparent' }}">
                  Admin Dashboard
              </x-responsive-nav-link>
          @endif
      @endauth
    </div>

    <!-- Mobile User Info & Settings -->
    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
      <div class="flex items-center px-4">
        <div class="flex-shrink-0 mr-3">
          <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-sm overflow-hidden">
            @if (Auth::user()->profile_photo_path)
              <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
            @else
              {{ substr(Auth::user()->name, 0, 1) }}
            @endif
          </div>
        </div>
        <div>
          <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
          <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
        </div>
      </div>
      <div class="mt-3 space-y-1">
        <x-responsive-nav-link :href="route('profile.edit')" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-700 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800 border-l-4 border-transparent">
          Settings
        </x-responsive-nav-link>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-700 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800 border-l-4 border-transparent">
            Log Out
          </x-responsive-nav-link>
        </form>
      </div>
    </div>
  </div>
</nav>
