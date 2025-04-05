<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Project Details') }}: {{ $project->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.projects.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded transition-colors duration-200">
                    {{ __('Back to Projects') }}
                </a>
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                        {{ __('Delete Project') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Project Details -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Project Information') }}</h3>
                        <div class="flex space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($project->status == 'planning') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                @elseif($project->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $project->is_public ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                {{ $project->is_public ? 'Public' : 'Private' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="mb-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Description') }}</h4>
                            <p class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $project->description }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ __('Project Details') }}</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Created By') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        <a href="{{ route('admin.users.show', $project->creator) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200 transition-colors duration-200">
                                            {{ $project->creator->name }}
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Date Created') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->created_at->format('F j, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Last Updated') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->updated_at->format('F j, Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ __('Timeline') }}</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Start Date') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->start_date->format('F j, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('End Date') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->end_date->format('F j, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Duration') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->start_date->diffInDays($project->end_date) + 1 }} days</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Statistics -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Project Statistics') }}</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg border border-indigo-100 dark:border-indigo-800">
                            <h4 class="text-sm font-medium text-indigo-800 dark:text-indigo-300 mb-1">{{ __('Members') }}</h4>
                            <p class="text-2xl font-semibold text-indigo-900 dark:text-indigo-200">{{ $project->members->count() }}</p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-100 dark:border-blue-800">
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300 mb-1">{{ __('Tasks') }}</h4>
                            <p class="text-2xl font-semibold text-blue-900 dark:text-blue-200">{{ $project->tasks->count() }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-100 dark:border-green-800">
                            <h4 class="text-sm font-medium text-green-800 dark:text-green-300 mb-1">{{ __('Files') }}</h4>
                            <p class="text-2xl font-semibold text-green-900 dark:text-green-200">{{ $project->files->count() }}</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-100 dark:border-yellow-800">
                            <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-300 mb-1">{{ __('Comments') }}</h4>
                            <p class="text-2xl font-semibold text-yellow-900 dark:text-yellow-200">{{ $project->comments->count() }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ __('Task Progress') }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            @php
                                $tasksByStatus = [
                                    'to_do' => $project->tasks->where('status', 'to_do')->count(),
                                    'in_progress' => $project->tasks->where('status', 'in_progress')->count(),
                                    'review' => $project->tasks->where('status', 'review')->count(),
                                    'completed' => $project->tasks->where('status', 'completed')->count(),
                                ];
                                $totalTasks = $project->tasks->count();
                            @endphp
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600 text-center">
                                <h5 class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('To Do') }}</h5>
                                <p class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $tasksByStatus['to_do'] }}</p>
                                <div class="mt-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                                    <div class="bg-gray-400 dark:bg-gray-500 h-2.5 rounded-full" style="width: {{ $totalTasks > 0 ? ($tasksByStatus['to_do'] / $totalTasks) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600 text-center">
                                <h5 class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('In Progress') }}</h5>
                                <p class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $tasksByStatus['in_progress'] }}</p>
                                <div class="mt-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                                    <div class="bg-blue-500 dark:bg-blue-600 h-2.5 rounded-full" style="width: {{ $totalTasks > 0 ? ($tasksByStatus['in_progress'] / $totalTasks) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600 text-center">
                                <h5 class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('In Review') }}</h5>
                                <p class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $tasksByStatus['review'] }}</p>
                                <div class="mt-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                                    <div class="bg-yellow-500 dark:bg-yellow-600 h-2.5 rounded-full" style="width: {{ $totalTasks > 0 ? ($tasksByStatus['review'] / $totalTasks) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600 text-center">
                                <h5 class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Completed') }}</h5>
                                <p class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $tasksByStatus['completed'] }}</p>
                                <div class="mt-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                                    <div class="bg-green-500 dark:bg-green-600 h-2.5 rounded-full" style="width: {{ $totalTasks > 0 ? ($tasksByStatus['completed'] / $totalTasks) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Members -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Project Members') }}</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($project->members->sortBy(function($member) { 
                            return $member->pivot->role === 'owner' ? 0 : ($member->pivot->role === 'member' ? 1 : 2);
                        }) as $member)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-sm">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <a href="{{ route('admin.users.show', $member) }}" class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                            {{ $member->name }}
                                        </a>
                                        <div class="flex mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                @if($member->pivot->role == 'owner') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                                @elseif($member->pivot->role == 'member') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                @endif">
                                                {{ ucfirst($member->pivot->role) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>