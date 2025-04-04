<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->title }}
            </h2>
            <div>
                @if($project->members->contains('id', Auth::id()) && $project->members->find(Auth::id())->pivot->role != 'pending')
                    <a href="{{ route('projects.tasks.index', $project) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                        {{ __('Tasks') }}
                    </a>
                    <a href="{{ route('projects.files.index', $project) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                        {{ __('Files') }}
                    </a>
                    <a href="{{ route('projects.messages.index', $project) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                        {{ __('Messages') }}
                    </a>
                @endif
                
                @if($project->creator_id == Auth::id())
                    <a href="{{ route('projects.edit', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Edit Project') }}
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Project Details') }}</h3>
                            
                            <div class="bg-gray-50 p-4 rounded mb-4">
                                <p class="text-gray-700 whitespace-pre-line">{{ $project->description }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">{{ __('Start Date') }}</p>
                                    <p class="text-sm text-gray-900">{{ $project->start_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">{{ __('End Date') }}</p>
                                    <p class="text-sm text-gray-900">{{ $project->end_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">{{ __('Status') }}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($project->status == 'planning') bg-gray-100 text-gray-800
                                        @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($project->status == 'completed') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">{{ __('Visibility') }}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $project->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $project->is_public ? __('Public') : __('Private') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Project Activity') }}</h3>
                                
                                <div class="space-y-4">
                                    <!-- Latest Tasks -->
                                    <div class="border rounded-lg p-4">
                                        <h4 class="text-md font-medium text-gray-800 mb-2">{{ __('Recent Tasks') }}</h4>
                                        @if($project->tasks->isEmpty())
                                            <p class="text-sm text-gray-500">{{ __('No tasks created yet.') }}</p>
                                        @else
                                            <ul class="divide-y divide-gray-200">
                                                @foreach($project->tasks->sortByDesc('created_at')->take(3) as $task)
                                                    <li class="py-2">
                                                        <div class="flex justify-between">
                                                            <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                                {{ $task->title }}
                                                            </a>
                                                            <span class="text-xs text-gray-500">{{ $task->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-xs text-gray-500">
                                                            {{ __('Status') }}: 
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                                @if($task->status == 'to_do') bg-gray-100 text-gray-800
                                                                @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800
                                                                @elseif($task->status == 'review') bg-yellow-100 text-yellow-800
                                                                @else bg-green-100 text-green-800
                                                                @endif">
                                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                            </span>
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @if($project->tasks->count() > 3)
                                                <div class="mt-2 text-right">
                                                    <a href="{{ route('projects.tasks.index', $project) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                                        {{ __('View all tasks') }} →
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    <!-- Latest Files -->
                                    <div class="border rounded-lg p-4">
                                        <h4 class="text-md font-medium text-gray-800 mb-2">{{ __('Recent Files') }}</h4>
                                        @if($project->files->isEmpty())
                                            <p class="text-sm text-gray-500">{{ __('No files uploaded yet.') }}</p>
                                        @else
                                            <ul class="divide-y divide-gray-200">
                                                @foreach($project->files->sortByDesc('created_at')->take(3) as $file)
                                                    <li class="py-2">
                                                        <div class="flex justify-between">
                                                            <a href="{{ route('projects.files.download', [$project, $file]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                                {{ $file->filename }}
                                                            </a>
                                                            <span class="text-xs text-gray-500">{{ $file->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-xs text-gray-500">
                                                            {{ __('Uploaded by') }} {{ $file->uploader->name }} 
                                                            ({{ round($file->filesize / 1024, 2) }} KB)
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @if($project->files->count() > 3)
                                                <div class="mt-2 text-right">
                                                    <a href="{{ route('projects.files.index', $project) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                                        {{ __('View all files') }} →
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    <!-- Latest Messages -->
                                    <div class="border rounded-lg p-4">
                                        <h4 class="text-md font-medium text-gray-800 mb-2">{{ __('Recent Messages') }}</h4>
                                        @if($project->messages->isEmpty())
                                            <p class="text-sm text-gray-500">{{ __('No messages sent yet.') }}</p>
                                        @else
                                            <ul class="divide-y divide-gray-200">
                                                @foreach($project->messages->sortByDesc('created_at')->take(3) as $message)
                                                    <li class="py-2">
                                                        <div class="flex justify-between">
                                                            <span class="text-sm font-medium text-gray-800">{{ $message->sender->name }}</span>
                                                            <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-sm text-gray-600">{{ Str::limit($message->content, 100) }}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @if($project->messages->count() > 3)
                                                <div class="mt-2 text-right">
                                                    <a href="{{ route('projects.messages.index', $project) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                                        {{ __('View all messages') }} →
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if($project->members->contains('id', Auth::id()) && $project->members->find(Auth::id())->pivot->role != 'pending')
                                <!-- Project Comments -->
                                <div class="mt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Project Comments') }}</h3>
                                    
                                    <form action="{{ route('projects.comments.store', $project) }}" method="POST" class="mb-4">
                                        @csrf
                                        <div class="mb-2">
                                            <textarea name="content" rows="3" 
                                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                      placeholder="{{ __('Add a comment...') }}" required></textarea>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                                                {{ __('Post Comment') }}
                                            </button>
                                        </div>
                                    </form>
                                    
                                    <div class="space-y-4">
                                        @foreach($project->comments->sortByDesc('created_at') as $comment)
                                            <div class="bg-gray-50 p-4 rounded">
                                                <div class="flex justify-between mb-2">
                                                    <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-gray-700 mb-2">{{ $comment->content }}</p>
                                                <div class="flex justify-end space-x-2">
                                                    @if($comment->user_id == Auth::id())
                                                        <form action="{{ route('projects.comments.destroy', [$project, $comment]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800">{{ __('Delete') }}</button>
                                                        </form>
                                                    @endif
                                                </div>
                                                
                                                <!-- Replies would go here -->
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <div class="bg-white border rounded-lg shadow-sm p-4 mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Team Members') }}</h3>
                                
                                <ul class="divide-y divide-gray-200">
                                    @foreach($members as $member)
                                        <li class="py-3 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                    @if($member->pivot->role == 'owner') bg-purple-100 text-purple-800
                                                    @elseif($member->pivot->role == 'member') bg-blue-100 text-blue-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    {{ ucfirst($member->pivot->role) }}
                                                </span>
                                            </div>
                                            
                                            @if($project->creator_id == Auth::id() && $member->id != Auth::id())
                                                <form action="{{ route('projects.members.remove', [$project, $member]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to remove this member?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800">{{ __('Remove') }}</button>
                                                </form>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                
                                @if($project->creator_id == Auth::id())
                                    <div class="mt-4 border-t pt-4">
                                        <h4 class="text-sm font-medium text-gray-800 mb-2">{{ __('Invite Team Members') }}</h4>
                                        <form action="{{ route('projects.invite', $project) }}" method="POST">
                                            @csrf
                                            <div class="flex">
                                                <input type="email" name="email" placeholder="{{ __('Enter email address') }}" 
                                                       class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                       required>
                                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md">
                                                    {{ __('Invite') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    @if($pendingMembers->count() > 0)
                                        <div class="mt-4">
                                            <h4 class="text-sm font-medium text-gray-800 mb-2">{{ __('Pending Invitations') }}</h4>
                                            <ul class="divide-y divide-gray-200 border rounded-md">
                                                @foreach($pendingMembers as $pendingMember)
                                                    <li class="py-2 px-3 text-sm">
                                                        <div class="flex justify-between items-center">
                                                            <span>{{ $pendingMember->email }}</span>
                                                            <form action="{{ route('projects.members.remove', [$project, $pendingMember]) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-xs text-red-600 hover:text-red-800">{{ __('Cancel') }}</button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            
                            @if($project->members->contains('id', Auth::id()) && $project->members->find(Auth::id())->pivot->role != 'pending')
                                <div class="bg-white border rounded-lg shadow-sm p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Quick Links') }}</h3>
                                    
                                    <div class="space-y-2">
                                        <a href="{{ route('projects.tasks.index', $project) }}" class="block w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            {{ __('All Tasks') }}
                                        </a>
                                        <a href="{{ route('projects.files.index', $project) }}" class="block w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            {{ __('File Repository') }}
                                        </a>
                                        <a href="{{ route('projects.messages.index', $project) }}" class="block w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            {{ __('Team Chat') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>