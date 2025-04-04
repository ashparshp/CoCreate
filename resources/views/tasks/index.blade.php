<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tasks') }} - {{ $project->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('projects.show', $project) }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded">
                    {{ __('Back to Project') }}
                </a>
                <a href="{{ route('projects.tasks.create', $project) }}" class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                    {{ __('Create Task') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Task Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap items-center gap-4">
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Status') }}</label>
                        <select id="status-filter" class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50">
                            <option value="all">{{ __('All') }}</option>
                            <option value="to_do">{{ __('To Do') }}</option>
                            <option value="in_progress">{{ __('In Progress') }}</option>
                            <option value="review">{{ __('Review') }}</option>
                            <option value="completed">{{ __('Completed') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="priority-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Priority') }}</label>
                        <select id="priority-filter" class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50">
                            <option value="all">{{ __('All') }}</option>
                            <option value="low">{{ __('Low') }}</option>
                            <option value="medium">{{ __('Medium') }}</option>
                            <option value="high">{{ __('High') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="assigned-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Assigned To') }}</label>
                        <select id="assigned-filter" class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50">
                            <option value="all">{{ __('All') }}</option>
                            <option value="me">{{ __('Assigned to me') }}</option>
                            <option value="unassigned">{{ __('Unassigned') }}</option>
                        </select>
                    </div>
                    
                    <div class="ml-auto">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Search') }}</label>
                        <input type="text" id="search" placeholder="{{ __('Search tasks...') }}" 
                               class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50">
                    </div>
                </div>
            </div>

            <!-- Task Kanban Board -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- To Do Column -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ __('To Do') }}</h3>
                    </div>
                    <div class="p-4 task-column" data-status="to_do">
                        @foreach($tasks->where('status', 'to_do') as $task)
                            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-sm p-4 mb-3 task-card" 
                                 data-id="{{ $task->id }}" 
                                 data-status="{{ $task->status }}" 
                                 data-priority="{{ $task->priority }}" 
                                 data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
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
                        @if($tasks->where('status', 'to_do')->isEmpty())
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-sm text-gray-500 dark:text-gray-400 text-center border border-gray-200 dark:border-gray-600">
                                {{ __('No tasks') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- In Progress Column -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ __('In Progress') }}</h3>
                    </div>
                    <div class="p-4 task-column" data-status="in_progress">
                        @foreach($tasks->where('status', 'in_progress') as $task)
                            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-sm p-4 mb-3 task-card" 
                                 data-id="{{ $task->id }}" 
                                 data-status="{{ $task->status }}" 
                                 data-priority="{{ $task->priority }}" 
                                 data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
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
                        @if($tasks->where('status', 'in_progress')->isEmpty())
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-sm text-gray-500 dark:text-gray-400 text-center border border-gray-200 dark:border-gray-600">
                                {{ __('No tasks') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Review Column -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ __('Review') }}</h3>
                    </div>
                    <div class="p-4 task-column" data-status="review">
                        @foreach($tasks->where('status', 'review') as $task)
                            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-sm p-4 mb-3 task-card" 
                                 data-id="{{ $task->id }}" 
                                 data-status="{{ $task->status }}" 
                                 data-priority="{{ $task->priority }}" 
                                 data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
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
                        @if($tasks->where('status', 'review')->isEmpty())
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-sm text-gray-500 dark:text-gray-400 text-center border border-gray-200 dark:border-gray-600">
                                {{ __('No tasks') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Completed Column -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ __('Completed') }}</h3>
                    </div>
                    <div class="p-4 task-column" data-status="completed">
                        @foreach($tasks->where('status', 'completed') as $task)
                            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-sm p-4 mb-3 task-card" 
                                 data-id="{{ $task->id }}" 
                                 data-status="{{ $task->status }}" 
                                 data-priority="{{ $task->priority }}" 
                                 data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
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
                                        <div>
                                            {{ $task->due_date->format('M d, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($tasks->where('status', 'completed')->isEmpty())
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-sm text-gray-500 dark:text-gray-400 text-center border border-gray-200 dark:border-gray-600">
                                {{ __('No tasks') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- List View Toggle -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ __('All Tasks') }}</h3>
                    <div>
                        <button id="toggle-view" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
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
                                    <tr class="task-row" 
                                        data-status="{{ $task->status }}" 
                                        data-priority="{{ $task->priority }}" 
                                        data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
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
                                            <div class="text-sm text-gray-900 dark:text-gray-100 {{ $task->due_date && $task->due_date->isPast() ? 'text-red-600 dark:text-red-400 font-bold' : '' }}">
                                                {{ $task->due_date ? $task->due_date->format('M d, Y') : '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">{{ __('Edit') }}</a>
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
