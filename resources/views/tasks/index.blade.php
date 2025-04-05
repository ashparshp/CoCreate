<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Tasks') }} - {{ $project->title }}
      </h2>
      <div class="flex space-x-2">
        <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold rounded transition-colors duration-200">
          {{ __('Back to Project') }}
        </a>
        <a href="{{ route('projects.tasks.create', $project) }}" class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded shadow-lg transition-all duration-200">
          {{ __('Create Task') }}
        </a>
      </div>
    </div>
  </x-slot>

  <!-- Outer Wrapper with a refined gradient background -->
  <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-100 to-indigo-200 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
      
      <!-- Task Filters -->
      <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center gap-6">
          <div>
            <label for="status-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
              {{ __('Status') }}
            </label>
            <select id="status-filter" class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50 transition-colors duration-200">
              <option value="all">{{ __('All') }}</option>
              <option value="to_do">{{ __('To Do') }}</option>
              <option value="in_progress">{{ __('In Progress') }}</option>
              <option value="review">{{ __('Review') }}</option>
              <option value="completed">{{ __('Completed') }}</option>
            </select>
          </div>

          <div>
            <label for="priority-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
              {{ __('Priority') }}
            </label>
            <select id="priority-filter" class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50 transition-colors duration-200">
              <option value="all">{{ __('All') }}</option>
              <option value="low">{{ __('Low') }}</option>
              <option value="medium">{{ __('Medium') }}</option>
              <option value="high">{{ __('High') }}</option>
            </select>
          </div>

          <div>
            <label for="assigned-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
              {{ __('Assigned To') }}
            </label>
            <select id="assigned-filter" class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50 transition-colors duration-200">
              <option value="all">{{ __('All') }}</option>
              <option value="me">{{ __('Assigned to me') }}</option>
              <option value="unassigned">{{ __('Unassigned') }}</option>
            </select>
          </div>

          <div class="ml-auto">
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
              {{ __('Search') }}
            </label>
            <input type="text" id="search" placeholder="{{ __('Search tasks...') }}"
                   class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50 transition-colors duration-200">
          </div>
        </div>
      </div>

      <!-- Task Kanban Board -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Kanban Column Template -->
        @php
          $statuses = ['to_do' => __('To Do'), 'in_progress' => __('In Progress'), 'review' => __('Review'), 'completed' => __('Completed')];
        @endphp

        @foreach($statuses as $statusKey => $statusLabel)
          <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
              <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ $statusLabel }}</h3>
            </div>
            <div class="p-4 task-column" data-status="{{ $statusKey }}">
              @php $filteredTasks = $tasks->where('status', $statusKey); @endphp
              @if($filteredTasks->isEmpty())
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-sm text-gray-500 dark:text-gray-400 text-center border border-gray-200 dark:border-gray-600">
                  {{ __('No tasks') }}
                </div>
              @else
                @foreach($filteredTasks as $task)
                  <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-sm p-4 mb-3 task-card transition-transform transform hover:scale-105" 
                       data-id="{{ $task->id }}" 
                       data-status="{{ $task->status }}" 
                       data-priority="{{ $task->priority }}" 
                       data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                    <div class="flex justify-between items-start mb-2">
                      <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-150">
                        {{ $task->title }}
                      </a>
                      <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                        @if($task->priority == 'low') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                        @endif">
                        {{ ucfirst($task->priority) }}
                      </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ Str::limit($task->description, 100) }}</p>
                    <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                      <div>
                        @if($task->assigned_to)
                          <span>{{ __('Assigned to') }}: {{ $task->assignedUser->name }}</span>
                        @else
                          <span>{{ __('Unassigned') }}</span>
                        @endif
                      </div>
                      @if($task->due_date)
                        <div class="{{ $task->due_date->isPast() ? 'text-red-600 dark:text-red-400 font-bold' : '' }}">
                          {{ $task->due_date->format('M d, Y') }}
                        </div>
                      @endif
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        @endforeach
      </div>

      <!-- List View Toggle -->
      <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
          <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ __('All Tasks') }}</h3>
          <div>
            <button id="toggle-view" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-150">
              {{ __('Switch to List View') }}
            </button>
          </div>
        </div>
        <div id="list-view" class="hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    {{ __('Title') }}
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    {{ __('Status') }}
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    {{ __('Priority') }}
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    {{ __('Assigned To') }}
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    {{ __('Due Date') }}
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">{{ __('Actions') }}</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($tasks as $task)
                  <tr class="task-row" data-status="{{ $task->status }}" data-priority="{{ $task->priority }}" data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-150">
                          {{ $task->title }}
                        </a>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($task->status == 'to_do') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                        @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                        @elseif($task->status == 'review') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($task->priority == 'low') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                        @endif">
                        {{ ucfirst($task->priority) }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900 dark:text-gray-100">
                        {{ $task->assigned_to ? $task->assignedUser->name : __('Unassigned') }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm {{ $task->due_date && $task->due_date->isPast() ? 'text-red-600 dark:text-red-400 font-bold' : 'text-gray-900 dark:text-gray-100' }}">
                        {{ $task->due_date ? $task->due_date->format('M d, Y') : '-' }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors duration-150">
                        {{ __('Edit') }}
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</x-app-layout>
