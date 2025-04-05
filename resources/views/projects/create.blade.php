<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Create New Project') }}
    </h2>
  </x-slot>

  <!-- Outer wrapper with a vibrant gradient background -->
  <div class="py-12 bg-gradient-to-br from-indigo-100 via-purple-200 to-indigo-300 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 border border-gray-200 dark:border-gray-700">
        <form method="POST" action="{{ route('projects.store') }}">
          @csrf

          <!-- Project Title -->
          <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              {{ __('Project Title') }}
            </label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"
                   required>
            @error('title')
              <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>

          <!-- Description -->
          <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              {{ __('Description') }}
            </label>
            <textarea name="description" id="description" rows="5"
                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"
                      required>{{ old('description') }}</textarea>
            @error('description')
              <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>

          <!-- Start and End Dates -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Start Date') }}
              </label>
              <input type="date" name="start_date" id="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                     class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"
                     required>
              @error('start_date')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('End Date') }}
              </label>
              <input type="date" name="end_date" id="end_date" value="{{ old('end_date', date('Y-m-d', strtotime('+1 month'))) }}"
                     class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"
                     required>
              @error('end_date')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Public Project Checkbox -->
          <div class="mb-6">
            <div class="flex items-center">
              <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', '1') ? 'checked' : '' }}
                     class="rounded border-gray-300 dark:border-gray-700 text-blue-600 dark:text-blue-500 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50 transition-colors duration-200">
              <label for="is_public" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                {{ __('Make this project visible to all users') }}
              </label>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
              {{ __('Public projects are discoverable by all users of the platform.') }}
            </p>
            @error('is_public')
              <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end space-x-4">
            <!-- Cancel Button -->
            <a href="{{ route('projects.index') }}" 
               class="inline-flex items-center px-5 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 shadow-sm">
              {{ __('Cancel') }}
            </a>
            <!-- Create Project Button -->
            <button type="submit" 
                    class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-lg">
              {{ __('Create Project') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
