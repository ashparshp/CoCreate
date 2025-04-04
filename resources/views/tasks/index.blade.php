<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }} - {{ $project->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('projects.show', $project) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                    {{ __('Back to Project') }}
                </a>
                <a href="{{ route('projects.tasks.create', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Create Task') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Task Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-4">
                <div class="flex flex-wrap items-center gap-4">
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                        <select id="status-filter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="all">{{ __('All') }}</option>
                            <option value="to_do">{{ __('To Do') }}</option>
                            <option value="in_progress">{{ __('In Progress') }}</option>
                            <option value="review">{{ __('Review') }}</option>
                            <option value="completed">{{ __('Completed') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="priority-filter" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Priority') }}</label>
                        <select id="priority-filter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="all">{{ __('All') }}</option>
                            <option value="low">{{ __('Low') }}</option>
                            <option value="medium">{{ __('Medium') }}</option>
                            <option value="high">{{ __('High') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="assigned-filter" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Assigned To') }}</label>
                        <select id="assigned-filter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="all">{{ __('All') }}</option>
                            <option value="me">{{ __('Assigned to me') }}</option>
                            <option value="unassigned">{{ __('Unassigned') }}</option>
                        </select>
                    </div>
                    
                    <div class="ml-auto">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search') }}</label>
                        <input type="text" id="search" placeholder="{{ __('Search tasks...') }}" 
                               class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>

            <!-- Task Kanban Board -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- To Do Column -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-gray-50 border-b">
                        <h3 class="font-medium text-gray-900">{{ __('To Do') }}</h3>
                    </div>
                    <div class="p-4 task-column" data-status="to_do">
                        @foreach($tasks->where('status', 'to_do') as $task)
                            <div class="bg-white border rounded-lg shadow-sm p-4 mb-3 task-card" 
                                 data-id="{{ $task->id }}" 
                                 data-status="{{ $task->status }}" 
                                 data-priority="{{ $task->priority }}" 
                                 data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="font-medium text-blue-600 hover:text-blue-800">
                                        {{ $task->title }}
                                    </a>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        @if($task->priority == 'low') bg-green-100 text-green-800
                                        @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                <div class="flex justify-between items-center text-xs text-gray-500">
                                    <div>
                                        @if($task->assigned_to)
                                            <span>{{ __('Assigned to') }}: {{ $task->assignedUser->name }}</span>
                                        @else
                                            <span>{{ __('Unassigned') }}</span>
                                        @endif
                                    </div>
                                    @if($task->due_date)
                                        <div class="{{ $task->due_date->isPast() ? 'text-red-600 font-bold' : '' }}">
                                            {{ $task->due_date->format('M d, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($tasks->where('status', 'to_do')->isEmpty())
                            <div class="bg-gray-50 p-4 rounded text-sm text-gray-500 text-center">
                                {{ __('No tasks') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- In Progress Column -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-gray-50 border-b">
                        <h3 class="font-medium text-gray-900">{{ __('In Progress') }}</h3>
                    </div>
                    <div class="p-4 task-column" data-status="in_progress">
                        @foreach($tasks->where('status', 'in_progress') as $task)
                            <div class="bg-white border rounded-lg shadow-sm p-4 mb-3 task-card" 
                                 data-id="{{ $task->id }}" 
                                 data-status="{{ $task->status }}" 
                                 data-priority="{{ $task->priority }}" 
                                 data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="font-medium text-blue-600 hover:text-blue-800">
                                        {{ $task->title }}
                                    </a>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        @if($task->priority == 'low') bg-green-100 text-green-800
                                        @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                <div class="flex justify-between items-center text-xs text-gray-500">
                                    <div>
                                        @if($task->assigned_to)
                                            <span>{{ __('Assigned to') }}: {{ $task->assignedUser->name }}</span>
                                        @else
                                            <span>{{ __('Unassigned') }}</span>
                                        @endif
                                    </div>
                                    @if($task->due_date)
                                        <div class="{{ $task->due_date->isPast() ? 'text-red-600 font-bold' : '' }}">
                                            {{ $task->due_date->format('M d, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($tasks->where('status', 'in_progress')->isEmpty())
                            <div class="bg-gray-50 p-4 rounded text-sm text-gray-500 text-center">
                                {{ __('No tasks') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Review Column -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-gray-50 border-b">
                        <h3 class="font-medium text-gray-900">{{ __('Review') }}</h3>
                    </div>
                    <div class="p-4 task-column" data-status="review">
                        @foreach($tasks->where('status', 'review') as $task)
                            <div class="bg-white border rounded-lg shadow-sm p-4 mb-3 task-card" 
                                 data-id="{{ $task->id }}" 
                                 data-status="{{ $task->status }}" 
                                 data-priority="{{ $task->priority }}" 
                                 data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="font-medium text-blue-600 hover:text-blue-800">
                                        {{ $task->title }}
                                    </a>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        @if($task->priority == 'low') bg-green-100 text-green-800
                                        @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                <div class="flex justify-between items-center text-xs text-gray-500">
                                    <div>
                                        @if($task->assigned_to)
                                            <span>{{ __('Assigned to') }}: {{ $task->assignedUser->name }}</span>
                                        @else
                                            <span>{{ __('Unassigned') }}</span>
                                        @endif
                                    </div>
                                    @if($task->due_date)
                                        <div class="{{ $task->due_date->isPast() ? 'text-red-600 font-bold' : '' }}">
                                            {{ $task->due_date->format('M d, Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($tasks->where('status', 'review')->isEmpty())
                            <div class="bg-gray-50 p-4 rounded text-sm text-gray-500 text-center">
                                {{ __('No tasks') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Completed Column -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-gray-50 border-b">
                        <h3 class="font-medium text-gray-900">{{ __('Completed') }}</h3>
                    </div>
                    <div class="p-4 task-column" data-status="completed">
                        @foreach($tasks->where('status', 'completed') as $task)
                            <div class="bg-white border rounded-lg shadow-sm p-4 mb-3 task-card" 
                                 data-id="{{ $task->id }}" 
                                 data-status="{{ $task->status }}" 
                                 data-priority="{{ $task->priority }}" 
                                 data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="font-medium text-blue-600 hover:text-blue-800">
                                        {{ $task->title }}
                                    </a>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        @if($task->priority == 'low') bg-green-100 text-green-800
                                        @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                <div class="flex justify-between items-center text-xs text-gray-500">
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
                            <div class="bg-gray-50 p-4 rounded text-sm text-gray-500 text-center">
                                {{ __('No tasks') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- List View Toggle -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-b flex justify-between items-center">
                    <h3 class="font-medium text-gray-900">{{ __('All Tasks') }}</h3>
                    <div>
                        <button id="toggle-view" class="text-sm text-blue-600 hover:text-blue-800">
                            {{ __('Switch to List View') }}
                        </button>
                    </div>
                </div>
                <div id="list-view" class="hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Title') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Priority') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Assigned To') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Due Date') }}
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">{{ __('Actions') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($tasks as $task)
                                    <tr class="task-row" 
                                        data-status="{{ $task->status }}" 
                                        data-priority="{{ $task->priority }}" 
                                        data-assigned="{{ $task->assigned_to == Auth::id() ? 'me' : ($task->assigned_to ? 'other' : 'unassigned') }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="hover:text-blue-600">
                                                    {{ $task->title }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($task->status == 'to_do') bg-gray-100 text-gray-800
                                                @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800
                                                @elseif($task->status == 'review') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($task->priority == 'low') bg-green-100 text-green-800
                                                @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $task->assigned_to ? $task->assignedUser->name : __('Unassigned') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 {{ $task->due_date && $task->due_date->isPast() ? 'text-red-600 font-bold' : '' }}">
                                                {{ $task->due_date ? $task->due_date->format('M d, Y') : '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Edit') }}</a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('status-filter');
            const priorityFilter = document.getElementById('priority-filter');
            const assignedFilter = document.getElementById('assigned-filter');
            const searchInput = document.getElementById('search');
            const toggleViewBtn = document.getElementById('toggle-view');
            const listView = document.getElementById('list-view');
            const kanbanView = document.querySelectorAll('.task-column');
            
            // Filter function
            function applyFilters() {
                const statusValue = statusFilter.value;
                const priorityValue = priorityFilter.value;
                const assignedValue = assignedFilter.value;
                const searchValue = searchInput.value.toLowerCase();
                
                // Filter cards in kanban view
                document.querySelectorAll('.task-card').forEach(card => {
                    const cardTitle = card.querySelector('a').textContent.toLowerCase();
                    const cardDesc = card.querySelector('p').textContent.toLowerCase();
                    const cardStatus = card.dataset.status;
                    const cardPriority = card.dataset.priority;
                    const cardAssigned = card.dataset.assigned;
                    
                    const statusMatch = statusValue === 'all' || cardStatus === statusValue;
                    const priorityMatch = priorityValue === 'all' || cardPriority === priorityValue;
                    const assignedMatch = assignedValue === 'all' || cardAssigned === assignedValue;
                    const searchMatch = searchValue === '' || cardTitle.includes(searchValue) || cardDesc.includes(searchValue);
                    
                    card.style.display = statusMatch && priorityMatch && assignedMatch && searchMatch ? 'block' : 'none';
                });
                
                // Filter rows in list view
                document.querySelectorAll('.task-row').forEach(row => {
                    const rowTitle = row.querySelector('a').textContent.toLowerCase();
                    const rowStatus = row.dataset.status;
                    const rowPriority = row.dataset.priority;
                    const rowAssigned = row.dataset.assigned;
                    
                    const statusMatch = statusValue === 'all' || rowStatus === statusValue;
                    const priorityMatch = priorityValue === 'all' || rowPriority === priorityValue;
                    const assignedMatch = assignedValue === 'all' || rowAssigned === assignedValue;
                    const searchMatch = searchValue === '' || rowTitle.includes(searchValue);
                    
                    row.style.display = statusMatch && priorityMatch && assignedMatch && searchMatch ? '' : 'none';
                });
                
                // Show/hide empty state messages in kanban view
                document.querySelectorAll('.task-column').forEach(column => {
                    const hasVisibleCards = Array.from(column.querySelectorAll('.task-card')).some(card => card.style.display !== 'none');
                    const emptyStateMsg = column.querySelector('.bg-gray-50');
                    
                    if (emptyStateMsg) {
                        emptyStateMsg.style.display = hasVisibleCards ? 'none' : 'block';
                    }
                });
            }
            
            // Add event listeners to filters
            statusFilter.addEventListener('change', applyFilters);
            priorityFilter.addEventListener('change', applyFilters);
            assignedFilter.addEventListener('change', applyFilters);
            searchInput.addEventListener('input', applyFilters);
            
            // Toggle between kanban and list view
            toggleViewBtn.addEventListener('click', function() {
                const isKanbanVisible = kanbanView[0].parentElement.style.display !== 'none';
                
                if (isKanbanVisible) {
                    kanbanView.forEach(column => column.parentElement.style.display = 'none');
                    listView.style.display = 'block';
                    toggleViewBtn.textContent = 'Switch to Kanban View';
                } else {
                    kanbanView.forEach(column => column.parentElement.style.display = 'block');
                    listView.style.display = 'none';
                    toggleViewBtn.textContent = 'Switch to List View';
                }
                
                applyFilters();
            });
        });
    </script>
</x-app-layout>

