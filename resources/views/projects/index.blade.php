<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Projects') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="bg-gradient-to-r from-indigo-600 to-indigo-800 hover:from-indigo-700 hover:to-indigo-900 text-white font-bold py-2 px-6 rounded-md shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                {{ __('Create New Project') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-100 to-indigo-200 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- My Projects Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700 mb-8 transition-all duration-300 hover:shadow-lg">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 dark:from-indigo-800 dark:to-indigo-900 p-4 sm:p-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">{{ __('My Projects') }}</h2>
                </div>
                
                @if($myProjects->isEmpty())
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('No projects yet') }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Get started by creating a new project.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white text-sm font-medium rounded-md shadow-md transition-colors duration-200">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('New Project') }}
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        @foreach($myProjects as $project)
                            <div class="project-card bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-600 transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1">
                                <div class="h-2 bg-gradient-to-r 
                                    @if($project->status == 'planning') from-gray-400 to-gray-500
                                    @elseif($project->status == 'in_progress') from-blue-400 to-blue-600
                                    @elseif($project->status == 'completed') from-green-400 to-green-600
                                    @else from-yellow-400 to-yellow-600
                                    @endif"></div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('projects.show', $project) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                                {{ $project->title }}
                                            </a>
                                        </h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($project->status == 'planning') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @elseif($project->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                        {{ Str::limit($project->description, 100) }}
                                    </p>
                                    
                                    <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}</span>
                                        <span class="inline-flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $project->members->count() }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-600">
                                        <div class="flex justify-between items-center">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-sm overflow-hidden">
                                                    {{ substr($project->creator->name, 0, 1) }}
                                                </div>
                                                <span class="ml-2 text-xs text-gray-600 dark:text-gray-300">{{ $project->creator->name }}</span>
                                            </div>
                                            
                                            <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium transition-colors duration-200">
                                                {{ __('View') }} →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Explore Public Projects Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 dark:from-purple-800 dark:to-pink-900 p-4 sm:p-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">{{ __('Explore Public Projects') }}</h2>
                </div>
                
                @if($publicProjects->isEmpty())
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('No public projects available') }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Check back later for new projects to join.') }}</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        @foreach($publicProjects as $project)
                            <div class="project-card bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-600 transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1">
                                <div class="h-2 bg-gradient-to-r 
                                    @if($project->status == 'planning') from-gray-400 to-gray-500
                                    @elseif($project->status == 'in_progress') from-blue-400 to-blue-600
                                    @elseif($project->status == 'completed') from-green-400 to-green-600
                                    @else from-yellow-400 to-yellow-600
                                    @endif"></div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('projects.show', $project) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                                {{ $project->title }}
                                            </a>
                                        </h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($project->status == 'planning') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @elseif($project->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                        {{ Str::limit($project->description, 100) }}
                                    </p>
                                    
                                    <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}</span>
                                        <span class="inline-flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $project->members->count() }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-600">
                                        <div class="flex justify-between items-center">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-sm overflow-hidden">
                                                    {{ substr($project->creator->name, 0, 1) }}
                                                </div>
                                                <span class="ml-2 text-xs text-gray-600 dark:text-gray-300">{{ $project->creator->name }}</span>
                                            </div>
                                            
                                            <div>
                                                @if($project->joinRequests->count() > 0 && $project->joinRequests->first()->status === 'pending')
                                                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-xs rounded-full">
                                                        {{ __('Request Pending') }}
                                                    </span>
                                                @else
                                                    <button type="button"
                                                            onclick="openJoinRequestModal({{ $project->id }}, '{{ $project->title }}')"
                                                            class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white text-xs rounded-full shadow-sm transition-colors duration-200">
                                                        {{ __('Request to Join') }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Join Request Modal -->
    <div id="joinRequestModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="joinModalContent">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Request to Join') }} <span id="projectTitle"></span></h3>
            
            <form id="joinRequestForm" action="" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Message (Optional)') }}
                    </label>
                    <textarea name="message" id="message" rows="4" 
                              class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200"
                              placeholder="{{ __('Introduce yourself and explain why you want to join this project...') }}"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeJoinModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md transition-colors duration-200">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                        {{ __('Send Request') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Join Request Modal Functionality
        function openJoinRequestModal(projectId, projectTitle) {
            const modal = document.getElementById('joinRequestModal');
            const modalContent = document.getElementById('joinModalContent');
            const form = document.getElementById('joinRequestForm');
            const titleSpan = document.getElementById('projectTitle');
            
            form.action = `/projects/${projectId}/request-join`;
            titleSpan.textContent = projectTitle;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function closeJoinModal() {
            const modal = document.getElementById('joinRequestModal');
            const modalContent = document.getElementById('joinModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
    
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>
