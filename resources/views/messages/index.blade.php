<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Team Chat') }} - {{ $project->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('projects.show', $project) }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded">
                    {{ __('Back to Project') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex flex-col h-[600px]">
                        <!-- Message List -->
                        <div class="flex-grow overflow-y-auto mb-4 p-4 border dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700" id="message-container">
                            @if($messages->isEmpty())
                                <div class="flex flex-col items-center justify-center h-full">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('No messages yet') }}</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">{{ __('Start the conversation with your team') }}</p>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($messages as $message)
                                        <div class="flex items-start {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                                            <div class="max-w-3/4 {{ $message->sender_id == Auth::id() ? 'bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-blue-100' : 'bg-white dark:bg-gray-800 border dark:border-gray-700' }} rounded-lg shadow-sm p-4">
                                                <div class="flex justify-between items-start mb-1">
                                                    <span class="font-medium text-sm {{ $message->sender_id == Auth::id() ? 'text-blue-800 dark:text-blue-200' : 'text-gray-900 dark:text-gray-100' }}">
                                                        {{ $message->sender->name }}
                                                    </span>
                                                    <span class="text-xs {{ $message->sender_id == Auth::id() ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400' }} ml-2">
                                                        {{ $message->created_at->format('M d, g:i A') }}
                                                    </span>
                                                </div>
                                                
                                                <p class="text-sm whitespace-pre-line {{ $message->sender_id == Auth::id() ? 'text-blue-800 dark:text-blue-200' : 'text-gray-800 dark:text-gray-200' }}">
                                                    {{ $message->content }}
                                                </p>
                                                
                                                @if($message->sender_id == Auth::id() || $project->creator_id == Auth::id())
                                                    <div class="flex justify-end mt-1">
                                                        <form action="{{ route('projects.messages.destroy', [$project, $message]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this message?') }}')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-xs {{ $message->sender_id == Auth::id() ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400' }} hover:underline">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <!-- Message Input -->
                        <div class="flex-none">
                            <form action="{{ route('projects.messages.store', $project) }}" method="POST" id="message-form">
                                @csrf
                                <div class="flex">
                                    <div class="flex-grow">
                                        <textarea name="content" id="message-input" rows="3" 
                                                  class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400"
                                                  placeholder="{{ __('Type your message...') }}" required></textarea>
                                    </div>
                                    <div class="ml-2 flex items-end">
                                        <button type="submit" class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 text-white px-4 py-2 rounded">
                                            {{ __('Send') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($messages->hasPages())
                        <div class="mt-4">
                            {{ $messages->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
