<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $task->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('projects.tasks.index', $project) }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded transition-colors duration-200">
                    {{ __('Back to Tasks') }}
                </a>
                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                    {{ __('Edit Task') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Task Details') }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Created by') }} {{ $task->creator->name }} {{ $task->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($task->status == 'to_do') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @elseif($task->status == 'review') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($task->priority == 'low') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @endif">
                                        {{ ucfirst($task->priority) }} {{ __('Priority') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded mb-6">
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $task->description ?: __('No description provided.') }}</p>
                            </div>
                            
                            <!-- Task Files -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-800 dark:text-gray-300 mb-2">{{ __('Task Files') }}</h4>
                                
                                <form action="{{ route('projects.tasks.files.upload', [$project, $task]) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                                    @csrf
                                    <div class="flex items-center">
                                        <input type="file" name="file" id="file" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-800" required onchange="previewFile()">
                                        <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-4 py-2 rounded transition-colors duration-200">
                                            {{ __('Upload') }}
                                        </button>
                                    </div>
                                    <div id="file-preview" class="mt-2"></div>
                                </form>
                                
                                @if($task->files->isEmpty())
                                    <div class="text-sm text-gray-500 dark:text-gray-400 italic">
                                        {{ __('No files uploaded yet.') }}
                                    </div>
                                @else
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-md overflow-hidden">
                                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($task->files as $file)
                                                <li class="p-3 flex justify-between items-center bg-white dark:bg-gray-800">
                                                    <div class="flex items-center">
                                                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $file->filename }}</div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ __('Uploaded by') }} {{ $file->uploader->name }} 
                                                                {{ $file->created_at->diffForHumans() }} 
                                                                ({{ round($file->filesize / 1024, 2) }} KB)
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('projects.files.download', [$project, $file]) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                                                            {{ __('Download') }}
                                                        </a>
                                                        @if($file->uploaded_by == Auth::id() || $project->creator_id == Auth::id())
                                                            <form action="{{ route('projects.files.destroy', [$project, $file]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this file?') }}')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors duration-200">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Task Comments -->
                            <div>
                                <h4 class="text-md font-medium text-gray-800 dark:text-gray-300 mb-2">{{ __('Comments') }}</h4>
                                
                                <form action="{{ route('projects.tasks.comments.store', [$project, $task]) }}" method="POST" class="mb-4">
                                    @csrf
                                    <div class="mb-2">
                                        <textarea name="content" rows="3" 
                                                  class="block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300"
                                                  placeholder="{{ __('Add a comment...') }}" required></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                            {{ __('Post Comment') }}
                                        </button>
                                    </div>
                                </form>
                                
                                <div class="space-y-4">
                                    @forelse($task->comments->sortByDesc('created_at') as $comment)
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                                            <div class="flex justify-between mb-2">
                                                <span class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 mb-2">{{ $comment->content }}</p>
                                            <div class="flex justify-end space-x-2">
                                                @if($comment->user_id == Auth::id())
                                                    <form action="{{ route('projects.comments.destroy', [$project, $comment]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors duration-200">{{ __('Delete') }}</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-sm text-gray-500 dark:text-gray-400 italic">
                                            {{ __('No comments yet.') }}
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-4 mb-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Task Info') }}</h3>
                                
                                <div class="space-y-3">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Assigned To') }}</h4>
                                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $task->assigned_to ? $task->assignedUser->name : __('Unassigned') }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Due Date') }}</h4>
                                        <p class="text-sm text-gray-900 dark:text-gray-100 {{ $task->due_date && $task->due_date->isPast() ? 'text-red-600 dark:text-red-400 font-bold' : '' }}">
                                            {{ $task->due_date ? $task->due_date->format('M d, Y') : __('No due date') }}
                                            
                                            @if($task->due_date && $task->due_date->isPast() && $task->status != 'completed')
                                                <span class="block text-red-600 dark:text-red-400 text-xs mt-1">{{ __('Overdue') }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Created') }}</h4>
                                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $task->created_at->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Last Updated') }}</h4>
                                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $task->updated_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Quick Actions') }}</h4>
                                    
                                    <div class="space-y-2">
                                        <form action="{{ route('projects.tasks.update', [$project, $task]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="title" value="{{ $task->title }}">
                                            <input type="hidden" name="description" value="{{ $task->description }}">
                                            <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">
                                            <input type="hidden" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                                            <input type="hidden" name="priority" value="{{ $task->priority }}">
                                            
                                            @if($task->status != 'completed')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-3 py-2 rounded text-sm transition-colors duration-200">
                                                    {{ __('Mark as Completed') }}
                                                </button>
                                            @else
                                                <input type="hidden" name="status" value="to_do">
                                                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-3 py-2 rounded text-sm transition-colors duration-200">
                                                    {{ __('Reopen Task') }}
                                                </button>
                                            @endif
                                        </form>
                                        
                                        @if(!$task->assigned_to)
                                            <form action="{{ route('projects.tasks.update', [$project, $task]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="title" value="{{ $task->title }}">
                                                <input type="hidden" name="description" value="{{ $task->description }}">
                                                <input type="hidden" name="assigned_to" value="{{ Auth::id() }}">
                                                <input type="hidden" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                                                <input type="hidden" name="priority" value="{{ $task->priority }}">
                                                <input type="hidden" name="status" value="{{ $task->status }}">
                                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition-colors duration-200">
                                                    {{ __('Assign to me') }}
                                                </button>
                                            </form>
                                        @elseif($task->assigned_to == Auth::id())
                                            <form action="{{ route('projects.tasks.update', [$project, $task]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="title" value="{{ $task->title }}">
                                                <input type="hidden" name="description" value="{{ $task->description }}">
                                                <input type="hidden" name="assigned_to" value="">
                                                <input type="hidden" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                                                <input type="hidden" name="priority" value="{{ $task->priority }}">
                                                <input type="hidden" name="status" value="{{ $task->status }}">
                                                <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-3 py-2 rounded text-sm transition-colors duration-200">
                                                    {{ __('Unassign from me') }}
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this task?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white px-3 py-2 rounded text-sm transition-colors duration-200">
                                                {{ __('Delete Task') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Project Info') }}</h3>
                                
                                <div class="space-y-3">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Project') }}</h4>
                                        <p class="text-sm text-blue-600 dark:text-blue-400">
                                            <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                                                {{ $project->title }}
                                            </a>
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Project Status') }}</h4>
                                        <p class="text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($project->status == 'planning') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                @elseif($project->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                            </span>
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Timeline') }}</h4>
                                        <p class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                                    <a href="{{ route('projects.tasks.index', $project) }}" class="block w-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-center px-3 py-2 rounded text-sm text-gray-700 dark:text-gray-300 transition-colors duration-200">
                                        {{ __('View All Project Tasks') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewFile() {
            const preview = document.getElementById('file-preview');
            const file = document.getElementById('file').files[0];
            
            if (file) {
                preview.innerHTML = `
                    <div class="flex items-center mt-2 bg-blue-50 dark:bg-blue-900/20 p-2 rounded border border-blue-100 dark:border-blue-800">
                        <svg class="h-5 w-5 text-blue-500 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <div class="text-sm font-medium text-blue-800 dark:text-blue-300">${file.name}</div>
                            <div class="text-xs text-blue-600 dark:text-blue-400">${(file.size / 1024).toFixed(2)} KB</div>
                        </div>
                    </div>
                `;
            } else {
                preview.innerHTML = '';
            }
        }
    </script>
</x-app-layout>