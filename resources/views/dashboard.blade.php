<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-secondary-800 dark:text-secondary-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <h3 class="text-lg font-medium text-secondary-900 dark:text-secondary-100 mb-4">{{ __('Welcome back') }}, {{ Auth::user()->name }}!</h3>
                
                @if(isset($pendingInvitations) && $pendingInvitations->count() > 0)
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-secondary-800 dark:text-secondary-200 mb-2">{{ __('Pending Project Invitations') }}</h4>
                        <div class="bg-warning-50 dark:bg-warning-900/20 p-4 rounded border border-warning-200 dark:border-warning-800">
                            <ul class="divide-y divide-warning-200 dark:divide-warning-800">
                                @foreach($pendingInvitations as $invitation)
                                    <li class="py-3 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                                        <div>
                                            <p class="font-medium text-secondary-900 dark:text-secondary-100">{{ $invitation->title }}</p>
                                            <p class="text-sm text-secondary-600 dark:text-secondary-400">{{ __('From') }}: {{ $invitation->creator->name }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('projects.accept', $invitation) }}" method="POST">
                                                @csrf
                                                <x-success-button>
                                                    {{ __('Accept') }}
                                                </x-success-button>
                                            </form>
                                            <form action="{{ route('projects.decline', $invitation) }}" method="POST">
                                                @csrf
                                                <x-danger-button>
                                                    {{ __('Decline') }}
                                                </x-danger-button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-md font-medium text-secondary-800 dark:text-secondary-200 mb-2">{{ __('Your Projects') }}</h4>
                        @if(isset($projects) && $projects->count() > 0)
                            <ul class="divide-y divide-secondary-200 dark:divide-secondary-700">
                                @foreach($projects->take(5) as $project)
                                    <li class="py-2">
                                        <a href="{{ route('projects.show', $project) }}" class="block hover:bg-secondary-50 dark:hover:bg-secondary-700/50 p-2 rounded">
                                            <p class="font-medium text-primary-600 dark:text-primary-400">{{ $project->title }}</p>
                                            <p class="text-sm text-secondary-600 dark:text-secondary-400">
                                                {{ __('Status') }}: 
                                                <x-status-badge :status="$project->status" />
                                            </p>
                                            <p class="text-sm text-secondary-600 dark:text-secondary-400">
                                                {{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}
                                            </p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            @if($projects->count() > 5)
                                <div class="mt-2 text-right">
                                    <a href="{{ route('projects.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300">
                                        {{ __('View all projects') }} →
                                    </a>
                                </div>
                            @endif
                        @else
                            <p class="text-secondary-600 dark:text-secondary-400">{{ __('You have no projects yet.') }}</p>
                            <a href="{{ route('projects.create') }}" class="inline-block mt-2 btn-primary">
                                {{ __('Create a project') }}
                            </a>
                        @endif
                    </div>
                    
                    <div>
                        <h4 class="text-md font-medium text-secondary-800 dark:text-secondary-200 mb-2">{{ __('Recent Tasks') }}</h4>
                        @if(isset($tasks) && $tasks->count() > 0)
                            <ul class="divide-y divide-secondary-200 dark:divide-secondary-700">
                                @foreach($tasks as $task)
                                    <li class="py-2">
                                        <a href="{{ route('projects.tasks.show', [$task->project, $task]) }}" class="block hover:bg-secondary-50 dark:hover:bg-secondary-700/50 p-2 rounded">
                                            <p class="font-medium text-secondary-900 dark:text-secondary-100">{{ $task->title }}</p>
                                            <p class="text-sm text-secondary-600 dark:text-secondary-400">
                                                {{ __('Project') }}: {{ $task->project->title }}
                                            </p>
                                            <p class="text-sm text-secondary-600 dark:text-secondary-400 flex flex-wrap gap-1">
                                                <x-status-badge :status="$task->status" type="task" class="mr-1" />
                                                <x-status-badge :status="$task->priority" type="priority" />
                                            </p>
                                            @if($task->due_date)
                                                <p class="text-sm {{ $task->due_date->isPast() && $task->status != 'completed' ? 'text-danger-600 dark:text-danger-400' : 'text-secondary-600 dark:text-secondary-400' }}">
                                                    {{ __('Due') }}: {{ $task->due_date->format('M d, Y') }}
                                                </p>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-secondary-600 dark:text-secondary-400">{{ __('You have no assigned tasks.') }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="mt-6">
                    <h4 class="text-md font-medium text-secondary-800 dark:text-secondary-200 mb-2">{{ __('Quick Actions') }}</h4>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('projects.create') }}" class="btn-primary">
                            {{ __('Create New Project') }}
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn-secondary">
                            {{ __('Update Skills Profile') }}
                        </a>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
