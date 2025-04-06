<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $project->title }}
      </h2>
      <div class="space-x-2">
        @if($project->members->contains('id', Auth::id()) && $project->members->find(Auth::id())->pivot->role != 'pending')
          <a href="{{ route('projects.tasks.index', $project) }}" class="bg-indigo-500 hover:bg-indigo-700 dark:bg-indigo-600 dark:hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded transition-colors duration-200">
            {{ __('Tasks') }}
          </a>
          <a href="{{ route('projects.files.index', $project) }}" class="bg-green-500 hover:bg-green-700 dark:bg-green-600 dark:hover:bg-green-500 text-white font-semibold py-2 px-4 rounded transition-colors duration-200">
            {{ __('Files') }}
          </a>
          <a href="{{ route('projects.messages.index', $project) }}" class="bg-yellow-500 hover:bg-yellow-700 dark:bg-yellow-600 dark:hover:bg-yellow-500 text-white font-semibold py-2 px-4 rounded transition-colors duration-200">
            {{ __('Messages') }}
          </a>
        @endif
        @if($project->creator_id == Auth::id())
          <a href="{{ route('projects.edit', $project) }}" class="bg-blue-500 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded transition-colors duration-200">
            {{ __('Edit Project') }}
          </a>
        @endif
      </div>
    </div>
  </x-slot>

  <!-- Outer wrapper with a refined gradient background -->
  <div class="py-12 bg-gradient-to-br from-indigo-50 to-indigo-200 dark:from-gray-800 dark:to-gray-900">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mb-6 border border-gray-200 dark:border-gray-700">
        <div class="p-6">
          <!-- Project Details Section -->
          <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
            {{ __('Project Details') }}
          </h3>
          <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded mb-6 border border-gray-200 dark:border-gray-600">
            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
              {{ $project->description }}
            </p>
          </div>
          <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Start Date') }}</p>
              <p class="text-sm text-gray-900 dark:text-gray-200">{{ $project->start_date->format('M d, Y') }}</p>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('End Date') }}</p>
              <p class="text-sm text-gray-900 dark:text-gray-200">{{ $project->end_date->format('M d, Y') }}</p>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</p>
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                @if($project->status == 'planning') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                @elseif($project->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                @endif">
                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
              </span>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Visibility') }}</p>
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                {{ $project->is_public ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                {{ $project->is_public ? __('Public') : __('Private') }}
              </span>
            </div>
          </div>

          <!-- Project Activity Section -->
          <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
              {{ __('Project Activity') }}
            </h3>
            <div class="space-y-6">
              <!-- Recent Tasks -->
              <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-2">
                  {{ __('Recent Tasks') }}
                </h4>
                @if($project->tasks->isEmpty())
                  <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No tasks created yet.') }}</p>
                @else
                  <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($project->tasks->sortByDesc('created_at')->take(3) as $task)
                      <li class="py-2">
                        <div class="flex justify-between">
                          <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-150">
                            {{ $task->title }}
                          </a>
                          <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $task->created_at->diffForHumans() }}
                          </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                          {{ __('Status') }}: 
                          <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            @if($task->status == 'to_do') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($task->status == 'review') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                          </span>
                        </p>
                      </li>
                    @endforeach
                  </ul>
                  @if($project->tasks->count() > 3)
                    <div class="mt-2 text-right">
                      <a href="{{ route('projects.tasks.index', $project) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-150">
                        {{ __('View all tasks') }} →
                      </a>
                    </div>
                  @endif
                @endif
              </div>
              
              <!-- Recent Files -->
              <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-2">
                  {{ __('Recent Files') }}
                </h4>
                @if($project->files->isEmpty())
                  <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No files uploaded yet.') }}</p>
                @else
                  <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($project->files->sortByDesc('created_at')->take(3) as $file)
                      <li class="py-2">
                        <div class="flex justify-between">
                          <a href="{{ route('projects.files.download', [$project, $file]) }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-150">
                            {{ $file->filename }}
                          </a>
                          <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $file->created_at->diffForHumans() }}
                          </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                          {{ __('Uploaded by') }} {{ $file->uploader->name }} ({{ round($file->filesize / 1024, 2) }} KB)
                        </p>
                      </li>
                    @endforeach
                  </ul>
                  @if($project->files->count() > 3)
                    <div class="mt-2 text-right">
                      <a href="{{ route('projects.files.index', $project) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-150">
                        {{ __('View all files') }} →
                      </a>
                    </div>
                  @endif
                @endif
              </div>
              
              <!-- Recent Messages -->
              <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-2">
                  {{ __('Recent Messages') }}
                </h4>
                @if($project->messages->isEmpty())
                  <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No messages sent yet.') }}</p>
                @else
                  <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($project->messages->sortByDesc('created_at')->take(3) as $message)
                      <li class="py-2">
                        <div class="flex justify-between">
                          <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $message->sender->name }}</span>
                          <span class="text-xs text-gray-500 dark:text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($message->content, 100) }}</p>
                      </li>
                    @endforeach
                  </ul>
                  @if($project->messages->count() > 3)
                    <div class="mt-2 text-right">
                      <a href="{{ route('projects.messages.index', $project) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-150">
                        {{ __('View all messages') }} →
                      </a>
                    </div>
                  @endif
                @endif
              </div>
            </div>
          </div>

          <!-- Project Comments (if user is an approved member) -->
          @if($project->members->contains('id', Auth::id()) && $project->members->find(Auth::id())->pivot->role != 'pending')
            <div class="mt-6">
              <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Project Comments') }}</h3>
              <form action="{{ route('projects.comments.store', $project) }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-2">
                  <textarea name="content" rows="3"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"
                            placeholder="{{ __('Add a comment...') }}" required></textarea>
                </div>
                <div class="flex justify-end">
                  <button type="submit" class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                    {{ __('Post Comment') }}
                  </button>
                </div>
              </form>
              <div class="space-y-4">
                @foreach($project->comments->sortByDesc('created_at') as $comment)
                  <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded border border-gray-200 dark:border-gray-600">
                    <div class="flex justify-between mb-2">
                      <span class="font-medium text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</span>
                      <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">{{ $comment->content }}</p>
                    <div class="flex justify-end space-x-2">
                      @if($comment->user_id == Auth::id())
                        <form action="{{ route('projects.comments.destroy', [$project, $comment]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                            {{ __('Delete') }}
                          </button>
                        </form>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>

      <!-- Sidebar: Team Members and Quick Links -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Team Members') }}</h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
              @foreach($members as $member)
                <li class="py-3 flex items-center justify-between">
                  <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $member->name }}</span>
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                      @if($member->pivot->role == 'owner') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                      @elseif($member->pivot->role == 'member') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                      @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                      @endif">
                      {{ ucfirst($member->pivot->role) }}
                    </span>
                  </div>
                  @if($project->creator_id == Auth::id() && $member->id != Auth::id())
                    <form action="{{ route('projects.members.remove', [$project, $member]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to remove this member?') }}')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                        {{ __('Remove') }}
                      </button>
                    </form>
                  @endif
                </li>
              @endforeach
            </ul>
            @if($project->creator_id == Auth::id())
              <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                <h4 class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">{{ __('Invite Team Members') }}</h4>
                <form action="{{ route('projects.invite', $project) }}" method="POST">
                  @csrf
                  <div class="flex">
                    <input type="email" name="email" placeholder="{{ __('Enter email address') }}"
                           class="flex-1 rounded-l-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"
                           required>
                    <button type="submit" class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 text-white px-4 py-2 rounded-r-md transition-colors duration-200">
                      {{ __('Invite') }}
                    </button>
                  </div>
                </form>
              </div>
              @if($pendingMembers->count() > 0)
                <div class="mt-4">
                  <h4 class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">{{ __('Pending Invitations') }}</h4>
                  <ul class="divide-y divide-gray-200 dark:divide-gray-700 border dark:border-gray-700 rounded-md">
                    @foreach($pendingMembers as $pendingMember)
                      <li class="py-2 px-3 text-sm">
                        <div class="flex justify-between items-center">
                          <span class="text-gray-700 dark:text-gray-300">{{ $pendingMember->email }}</span>
                          <form action="{{ route('projects.members.remove', [$project, $pendingMember]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                              {{ __('Cancel') }}
                            </button>
                          </form>
                        </div>
                      </li>
                    @endforeach
                  </ul>
                </div>
              @endif
            @endif
          </div>
        </div>
        <div>
          @if($project->members->contains('id', Auth::id()) && $project->members->find(Auth::id())->pivot->role != 'pending')
            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-sm p-6">
              <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Quick Links') }}</h3>
              <div class="space-y-2">
                <a href="{{ route('projects.tasks.index', $project) }}" class="block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md py-2 px-3 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150">
                  {{ __('All Tasks') }}
                </a>
                <a href="{{ route('projects.files.index', $project) }}" class="block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md py-2 px-3 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150">
                  {{ __('File Repository') }}
                </a>
                <a href="{{ route('projects.messages.index', $project) }}" class="block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md py-2 px-3 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150">
                  {{ __('Team Chat') }}
                </a>
              </div>
            </div>
          @endif
        </div>
      </div>

      <!-- Add this section in the projects/show.blade.php file, after the Team Members section -->

@if($project->creator_id == Auth::id() && $joinRequests->count() > 0)
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Join Requests') }} ({{ $joinRequests->where('status', 'pending')->count() }})</h3>
    
    @if($joinRequests->where('status', 'pending')->count() > 0)
        <ul class="space-y-4">
            @foreach($joinRequests->where('status', 'pending') as $request)
                <li class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 animate-fadeIn" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center mb-3 sm:mb-0">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-sm overflow-hidden">
                                {{ substr($request->user->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $request->user->name }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Requested') }}: {{ $request->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <form action="{{ route('projects.approve-join-request', [$project, $request->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white text-xs rounded-md shadow transition-colors duration-200">
                                    {{ __('Approve') }}
                                </button>
                            </form>
                            <form action="{{ route('projects.reject-join-request', [$project, $request->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white text-xs rounded-md shadow transition-colors duration-200">
                                    {{ __('Decline') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @if($request->message)
                        <div class="mt-3 px-4 py-3 bg-gray-100 dark:bg-gray-600 rounded text-sm text-gray-700 dark:text-gray-300 border-l-4 border-indigo-400 dark:border-indigo-500">
                            {{ $request->message }}
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No pending join requests.') }}</p>
    @endif
</div>
@endif

<!-- Only show join project section if user is not a member AND project is public -->
@if(!$project->members->contains('id', Auth::id()) && $project->is_public === true)
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Join This Project') }}</h3>
        
        @if($userJoinRequest)
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                @if($userJoinRequest->status === 'pending')
                    <p class="text-yellow-600 dark:text-yellow-400 font-medium mb-2">{{ __('Your request to join this project is pending approval.') }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">{{ __('You will be notified when the project owner reviews your request.') }}</p>
                    <form action="{{ route('projects.cancel-join-request', $project) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 text-sm rounded-md transition-colors duration-200">
                            {{ __('Cancel Request') }}
                        </button>
                    </form>
                @elseif($userJoinRequest->status === 'rejected')
                    <p class="text-red-600 dark:text-red-400 font-medium">{{ __('Your request to join this project was not approved.') }}</p>
                @endif
            </div>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">{{ __('Interested in collaborating on this project?') }}</p>
            @if($project->requires_approval)
                <button type="button" 
                        onclick="openJoinRequestModal({{ $project->id }}, '{{ $project->title }}')" 
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                    {{ __('Request to Join') }}
                </button>
            @else
                <form action="{{ route('projects.request-join', $project) }}" method="POST">
                    @csrf
                    <button type="submit" 
                           class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                        {{ __('Join Project') }}
                    </button>
                </form>
            @endif
        @endif
    </div>
@endif

<!-- Join Request Modal (same as in index.blade.php) -->
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
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md shadow-md hover:shadow-lg transition-all duration-200">
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
    </div>
  </div>
</x-app-layout>
