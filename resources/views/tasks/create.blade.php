<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Create Task') }} - {{ $project->title }}
    </h2>
  </x-slot>

  <!-- Outer container with a modern gradient background -->
  <div class="py-12 bg-gradient-to-r from-indigo-50 via-purple-50 to-indigo-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 border border-gray-200 dark:border-gray-700">
        <form method="POST" action="{{ route('projects.tasks.store', $project) }}">
          @csrf

          <!-- Task Title -->
          <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              {{ __('Task Title') }}
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
                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">{{ old('description') }}</textarea>
            @error('description')
              <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status & Priority -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Status') }}
              </label>
              <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200" required>
                <option value="to_do" {{ old('status') == 'to_do' ? 'selected' : '' }}>{{ __('To Do') }}</option>
                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                <option value="review" {{ old('status') == 'review' ? 'selected' : '' }}>{{ __('Review') }}</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
              </select>
              @error('status')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Priority') }}
              </label>
              <select name="priority" id="priority" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200" required>
                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>{{ __('Low') }}</option>
                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>{{ __('Medium') }}</option>
                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>{{ __('High') }}</option>
              </select>
              @error('priority')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Assignment & Due Date -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Assigned To') }}
              </label>
              <select name="assigned_to" id="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                <option value="">{{ __('Unassigned') }}</option>
                @foreach($members as $member)
                  <option value="{{ $member->id }}" {{ old('assigned_to') == $member->id ? 'selected' : '' }}>
                    {{ $member->name }}
                  </option>
                @endforeach
              </select>
              @error('assigned_to')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Due Date') }}
              </label>
              <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" 
                     class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
              @error('due_date')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end space-x-4">
            <a href="{{ route('projects.tasks.index', $project) }}" class="inline-flex items-center px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold rounded transition-colors duration-200">
              {{ __('Cancel') }}
            </a>
            <button type="submit" class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded shadow-lg transition-all duration-200">
              {{ __('Create Task') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
