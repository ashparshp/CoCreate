<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-lg mr-3">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ __('Welcome back') }}, {{ Auth::user()->name }}!</h3>
                    </div>
                    
                    @if(isset($pendingInvitations) && $pendingInvitations->count() > 0)
                        <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg border border-yellow-200 dark:border-yellow-800 overflow-hidden">
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 px-4 py-3 border-b border-yellow-200 dark:border-yellow-800">
                                <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ __('Pending Project Invitations') }}
                                </h4>
                            </div>
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($pendingInvitations as $invitation)
                                    <li class="px-4 py-3 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $invitation->title }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('From') }}: {{ $invitation->creator->name }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('projects.accept', $invitation) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    {{ __('Accept') }}
                                                </button>
                                            </form>
                                            <form action="{{ route('projects.decline', $invitation) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    {{ __('Decline') }}
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                    {{ __('Your Projects') }}
                                </h4>
                            </div>
                            @if(isset($projects) && $projects->count() > 0)
                                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($projects->take(5) as $project)
                                        <li class="px-4 py-3 transition hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                            <a href="{{ route('projects.show', $project) }}" class="block">
                                                <div class="flex justify-between items-start mb-1">
                                                    <p class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">{{ $project->title }}</p>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $project->status == 'planning' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : 
                                                       ($project->status == 'in_progress' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300' : 
                                                       ($project->status == 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 
                                                       'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300')) }}">
                                                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}
                                                </p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($projects->count() > 5)
                                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 text-right">
                                        <a href="{{ route('projects.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center justify-end">
                                            {{ __('View all projects') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="p-4 text-center">
                                    <p class="text-gray-600 dark:text-gray-400 mb-3">{{ __('You have no projects yet.') }}</p>
                                    <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        {{ __('Create a project') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    {{ __('Recent Tasks') }}
                                </h4>
                            </div>
                            @if(isset($tasks) && $tasks->count() > 0)
                                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($tasks as $task)
                                        <li class="px-4 py-3 transition hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                            <a href="{{ route('projects.tasks.show', [$task->project, $task]) }}" class="block">
                                                <div class="flex justify-between items-start mb-1">
                                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $task->title }}</p>
                                                    <div class="flex gap-1">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $task->status == 'to_do' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : 
                                                           ($task->status == 'in_progress' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300' : 
                                                           ($task->status == 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 
                                                           'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300')) }}">
                                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                        </span>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $task->priority == 'low' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 
                                                           ($task->priority == 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 
                                                           'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300') }}">
                                                            {{ ucfirst($task->priority) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                                    {{ __('Project') }}: {{ $task->project->title }}
                                                </p>
                                                @if($task->due_date)
                                                    <p class="text-sm flex items-center {{ $task->due_date->isPast() && $task->status != 'completed' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 {{ $task->due_date->isPast() && $task->status != 'completed' ? 'text-red-600 dark:text-red-400' : 'text-gray-400 dark:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        {{ __('Due') }}: {{ $task->due_date->format('M d, Y') }}
                                                    </p>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="p-4 text-center">
                                    <p class="text-gray-600 dark:text-gray-400">{{ __('You have no assigned tasks.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-indigo-50 dark:bg-indigo-900/20 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                {{ __('Quick Actions') }}
                            </h4>
                        </div>
                        <div class="p-4 flex flex-wrap gap-3">
                            <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('Create New Project') }}
                            </a>
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ __('Update Skills Profile') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
