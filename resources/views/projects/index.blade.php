<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Projects') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Create New Project') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- My Projects -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('My Projects') }}</h2>
                    
                    @if($myProjects->isEmpty())
                        <div class="bg-gray-50 p-4 rounded text-gray-700">
                            <p>{{ __('You don\'t have any projects yet.') }}</p>
                            <div class="mt-2">
                                <a href="{{ route('projects.create') }}" class="text-blue-600 hover:text-blue-800">
                                    {{ __('Start a new project') }} →
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">{{ __('Project') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Status') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Timeline') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Role') }}</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">{{ __('Actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($myProjects as $project)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm">
                                                <div class="font-medium text-gray-900">
                                                    <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600">
                                                        {{ $project->title }}
                                                    </a>
                                                </div>
                                                <div class="text-gray-500">{{ Str::limit($project->description, 60) }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($project->status == 'planning') bg-gray-100 text-gray-800
                                                    @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800
                                                    @elseif($project->status == 'completed') bg-green-100 text-green-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($project->pivot->role == 'owner') bg-purple-100 text-purple-800
                                                    @elseif($project->pivot->role == 'member') bg-blue-100 text-blue-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    {{ ucfirst($project->pivot->role) }}
                                                </span>
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-900 mr-3">{{ __('View') }}</a>
                                                
                                                @if($project->pivot->role != 'pending')
                                                    <a href="{{ route('projects.tasks.index', $project) }}" class="text-blue-600 hover:text-blue-900 mr-3">{{ __('Tasks') }}</a>
                                                    
                                                    @if($project->creator_id == Auth::id())
                                                        <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Discover Public Projects') }}</h2>
                    
                    @if($publicProjects->isEmpty())
                        <div class="bg-gray-50 p-4 rounded text-gray-700">
                            {{ __('No public projects available right now.') }}
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($publicProjects as $project)
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div class="p-4">
                                        <h3 class="text-md font-medium text-gray-900 mb-1">
                                            <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600">
                                                {{ $project->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500 mb-3">{{ __('by') }} {{ $project->creator->name }}</p>
                                        <p class="text-sm text-gray-700 mb-3 h-12 overflow-hidden">
                                            {{ Str::limit($project->description, 100) }}
                                        </p>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($project->status == 'planning') bg-gray-100 text-gray-800
                                                @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800
                                                @elseif($project->status == 'completed') bg-green-100 text-green-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                {{ $project->members->count() }} {{ __('members') }}
                                            </span>
                                        </div>
                                        <div class="border-t border-gray-200 pt-3 mt-1">
                                            <a href="{{ route('projects.show', $project) }}" class="text-sm text-blue-600 hover:text-blue-800">
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
