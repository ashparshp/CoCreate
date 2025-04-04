<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Welcome back') }}, {{ Auth::user()->name }}!</h3>
                
                @if($pendingInvitations->count() > 0)
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-800 mb-2">{{ __('Pending Project Invitations') }}</h4>
                        <div class="bg-yellow-50 p-4 rounded border border-yellow-200">
                            <ul class="divide-y divide-yellow-200">
                                @foreach($pendingInvitations as $invitation)
                                    <li class="py-3 flex justify-between">
                                        <div>
                                            <p class="font-medium">{{ $invitation->title }}</p>
                                            <p class="text-sm text-gray-600">{{ __('From') }}: {{ $invitation->creator->name }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('projects.accept', $invitation) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm">
                                                    {{ __('Accept') }}
                                                </button>
                                            </form>
                                            <form action="{{ route('projects.decline', $invitation) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                                                    {{ __('Decline') }}
                                                </button>
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
                        <h4 class="text-md font-medium text-gray-800 mb-2">{{ __('Your Projects') }}</h4>
                        @if($projects->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($projects->take(5) as $project)
                                    <li class="py-2">
                                        <a href="{{ route('projects.show', $project) }}" class="block hover:bg-gray-50 p-2 rounded">
                                            <p class="font-medium text-blue-600">{{ $project->title }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ __('Status') }}: 
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($project->status == 'planning') bg-gray-100 text-gray-800
                                                    @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800
                                                    @elseif($project->status == 'completed') bg-green-100 text-green-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                {{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}
                                            </p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            @if($projects->count() > 5)
                                <div class="mt-2 text-right">
                                    <a href="{{ route('projects.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        {{ __('View all projects') }} →
                                    </a>
                                </div>
                            @endif
                        @else
                            <p class="text-gray-600">{{ __('You have no projects yet.') }}</p>
                            <a href="{{ route('projects.create') }}" class="inline-block mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                                {{ __('Create a project') }}
                            </a>
                        @endif
                    </div>
                    
                    <div>
                        <h4 class="text-md font-medium text-gray-800 mb-2">{{ __('Recent Tasks') }}</h4>
                        @if($tasks->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($tasks as $task)
                                    <li class="py-2">
                                        <a href="{{ route('projects.tasks.show', [$task->project, $task]) }}" class="block hover:bg-gray-50 p-2 rounded">
                                            <p class="font-medium">{{ $task->title }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ __('Project') }}: {{ $task->project->title }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                {{ __('Status') }}: 
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($task->status == 'to_do') bg-gray-100 text-gray-800
                                                    @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800
                                                    @elseif($task->status == 'review') bg-yellow-100 text-yellow-800
                                                    @else bg-green-100 text-green-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                                
                                                {{ __('Priority') }}:
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($task->priority == 'low') bg-green-100 text-green-800
                                                    @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </p>
                                            @if($task->due_date)
                                                <p class="text-sm text-gray-600">
                                                    {{ __('Due') }}: {{ $task->due_date->format('M d, Y') }}
                                                </p>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600">{{ __('You have no assigned tasks.') }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="mt-6">
                    <h4 class="text-md font-medium text-gray-800 mb-2">{{ __('Quick Actions') }}</h4>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            {{ __('Create New Project') }}
                        </a>
                        <a href="{{ route('profile.edit') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            {{ __('Update Skills Profile') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
