<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Edit Project') }}
    </h2>
  </x-slot>

  <!-- Outer wrapper with a refined gradient background -->
  <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-100 to-indigo-200 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 border border-gray-200 dark:border-gray-700">
        <form method="POST" action="{{ route('projects.update', $project) }}">
          @csrf
          @method('PUT')

          <!-- Project Title -->
          <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              {{ __('Project Title') }}
            </label>
            <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}"
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
                      required>{{ old('description', $project->description) }}</textarea>
            @error('description')
              <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>

          <!-- Start & End Dates -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Start Date') }}
              </label>
              <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}"
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
              <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $project->end_date->format('Y-m-d')) }}"
                     class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"
                     required>
              @error('end_date')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Project Status -->
          <div class="mb-6">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              {{ __('Project Status') }}
            </label>
            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
              <option value="planning" {{ (old('status', $project->status) == 'planning') ? 'selected' : '' }}>{{ __('Planning') }}</option>
              <option value="in_progress" {{ (old('status', $project->status) == 'in_progress') ? 'selected' : '' }}>{{ __('In Progress') }}</option>
              <option value="on_hold" {{ (old('status', $project->status) == 'on_hold') ? 'selected' : '' }}>{{ __('On Hold') }}</option>
              <option value="completed" {{ (old('status', $project->status) == 'completed') ? 'selected' : '' }}>{{ __('Completed') }}</option>
            </select>
            @error('status')
              <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>

          <!-- Project Visibility Settings -->
          <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg mb-6 border border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
              {{ __('Project Visibility Settings') }}
            </h3>

            <!-- Public Project Checkbox -->
            <div class="mb-4">
              <div class="flex items-center">
                <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', $project->is_public) ? 'checked' : '' }}
                       class="rounded border-gray-300 dark:border-gray-700 text-blue-600 dark:text-blue-500 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50 transition-colors duration-200">
                <label for="is_public" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                  {{ __('Make this project visible to all users') }}
                </label>
              </div>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 ml-6">
                {{ __('Public projects are discoverable by all users of the platform.') }}
              </p>
              @error('is_public')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>

            <!-- Require Approval for Join Requests -->
            <div id="joinApprovalSection" {{ !$project->is_public ? 'class="hidden"' : '' }}>
              <div class="flex items-center">
                <input type="checkbox" name="requires_approval" id="requires_approval" value="1" {{ old('requires_approval', $project->requires_approval) ? 'checked' : '' }}
                       class="rounded border-gray-300 dark:border-gray-700 text-blue-600 dark:text-blue-500 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50 transition-colors duration-200">
                <label for="requires_approval" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                  {{ __('Require approval for join requests') }}
                </label>
              </div>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 ml-6">
                {{ __('If enabled, you must manually approve requests from users who want to join your project.') }}
              </p>
              @error('requires_approval')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end space-x-4">
            <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-5 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
              {{ __('Cancel') }}
            </a>
            <button type="submit" class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-md shadow-lg transition-all duration-200">
              {{ __('Update Project') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const isPublicCheckbox = document.getElementById('is_public');
      const joinApprovalSection = document.getElementById('joinApprovalSection');
      const requiresApprovalCheckbox = document.getElementById('requires_approval');
      
      // Initial state
      toggleJoinApprovalSection();
      
      // Add event listener
      isPublicCheckbox.addEventListener('change', toggleJoinApprovalSection);
      
      function toggleJoinApprovalSection() {
        if (isPublicCheckbox.checked) {
          joinApprovalSection.classList.remove('hidden');
        } else {
          joinApprovalSection.classList.add('hidden');
          // If project is not public, automatically set requires_approval to false
          // since it doesn't make sense to require approval for a private project
          requiresApprovalCheckbox.checked = false;
        }
      }
    });
  </script>
</x-app-layout>
