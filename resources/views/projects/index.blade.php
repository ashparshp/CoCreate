<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Projects') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                {{ __('Create New Project') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- My Projects -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('My Projects') }}</h2>
                    
                    @if($myProjects->isEmpty())
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-gray-700 dark:text-gray-300">
                            <p>{{ __('You don\'t have any projects yet.') }}</p>
                            <div class="mt-2">
                                <a href="{{ route('projects.create') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    {{ __('Start a new project') }} →
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 dark:ring-gray-700 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">{{ __('Project') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">{{ __('Status') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">{{ __('Timeline') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">{{ __('Role') }}</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">{{ __('Actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-white dark:bg-gray-800">
                                    @foreach($myProjects as $project)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm">
                                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                                    <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                                        {{ $project->title }}
                                                    </a>
                                                </div>
                                                <div class="text-gray-500 dark:text-gray-400">{{ Str::limit($project->description, 60) }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($project->status == 'planning') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                    @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                    @elseif($project->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($project->pivot->role == 'owner') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                                    @elseif($project->pivot->role == 'member') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                    @endif">
                                                    {{ ucfirst($project->pivot->role) }}
                                                </span>
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a href="{{ route('projects.show', $project) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3">{{ __('View') }}</a>
                                                
                                                @if($project->pivot->role != 'pending')
                                                    <a href="{{ route('projects.tasks.index', $project) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3">{{ __('Tasks') }}</a>
                                                    
                                                    @if($project->creator_id == Auth::id())
                                                        <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">{{ __('Edit') }}</a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Public Projects -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Discover Public Projects') }}</h2>
                    
                    @if($publicProjects->isEmpty())
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-gray-700 dark:text-gray-300">
                            {{ __('No public projects available right now.') }}
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($publicProjects as $project)
                                <div class="border dark:border-gray-700 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 bg-white dark:bg-gray-800">
                                    <div class="p-4">
                                        <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-1">
                                            <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $project->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ __('by') }} {{ $project->creator->name }}</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-3 h-12 overflow-hidden">
                                            {{ Str::limit($project->description, 100) }}
                                        </p>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($project->status == 'planning') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                @elseif($project->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $project->members->count() }} {{ __('members') }}
                                            </span>
                                        </div>
                                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-1">
                                            <a href="{{ route('projects.show', $project) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                                {{ __('View Project') }} →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
