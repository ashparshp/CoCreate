@extends('layouts.admin')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Project Details') }}
        </h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.projects.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded transition-colors duration-200">
                {{ __('Back to Projects') }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Project Overview -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $project->title }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($project->status == 'planning') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($project->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                {{ __('Description') }}
                            </h4>
                            <div class="prose dark:prose-invert max-w-none">
                                {{ $project->description }}
                            </div>
                            
                            @if(isset($project->requirements))
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-6 mb-3">
                                    {{ __('Requirements') }}
                                </h4>
                                <div class="prose dark:prose-invert max-w-none">
                                    {{ $project->requirements }}
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                {{ __('Project Details') }}
                            </h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Created By') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-6 w-6">
                                                <div class="h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-xs">
                                                    {{ substr($project->creator->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.users.show', $project->creator) }}" class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium transition-colors duration-200">
                                                {{ $project->creator->name }}
                                            </a>
                                        </div>
                                    </dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Created On') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $project->created_at->format('F j, Y') }}
                                    </dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Timeline') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}
                                    </dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Visibility') }}
                                    </dt>
                                    <dd class="mt-1 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $project->is_public ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                            {{ $project->is_public ? 'Public' : 'Private' }}
                                        </span>
                                    </dd>
                                </div>
                                
                                @if(isset($project->budget))
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            {{ __('Budget') }}
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            ${{ number_format($project->budget, 2) }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Skills -->
            @if(isset($project->skills) && method_exists($project->skills, 'count'))
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Required Skills') }}</h3>
                </div>
                
                <div class="p-6">
                    @if($project->skills->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($project->skills as $skill)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No specific skills are required for this project.') }}</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Project Team Members -->
            @if(isset($project->team_members) && method_exists($project->team_members, 'count'))
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Team Members') }}</h3>
                </div>
                
                <div class="p-6">
                    @if($project->team_members->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($project->team_members as $member)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-md">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <a href="{{ route('admin.users.show', $member) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                            {{ $member->name }}
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ isset($member->pivot) && isset($member->pivot->role) ? $member->pivot->role : 'Team Member' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No team members have been assigned to this project yet.') }}</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Project Tasks -->
            @if(isset($project->tasks) && method_exists($project->tasks, 'count'))
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Tasks') }}</h3>
                </div>
                
                <div class="overflow-x-auto">
                    @if($project->tasks->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Task') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Assignee') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Due Date') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($project->tasks as $task)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $task->title }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ Str::limit($task->description, 40) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(isset($task->assignee))
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-6 w-6">
                                                        <div class="h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-xs">
                                                            {{ substr($task->assignee->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('admin.users.show', $task->assignee) }}" class="ml-2 text-sm text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                                        {{ $task->assignee->name }}
                                                    </a>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Unassigned') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($task->status == 'pending') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                @elseif($task->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ isset($task->due_date) ? $task->due_date->format('M d, Y') : 'No deadline' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-6">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No tasks have been created for this project yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Comments Section (simplified) -->
            @if(isset($project->comments) && method_exists($project->comments, 'count'))
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Comments') }}</h3>
                </div>
                
                <div class="p-6">
                    @if($project->comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($project->comments as $comment)
                                <div class="flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-md">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <div class="flex justify-between mb-2">
                                            <div>
                                                <a href="{{ route('admin.users.show', $comment->user) }}" class="font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                                                    {{ $comment->user->name }}
                                                </a>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $comment->content }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No comments have been added to this project yet.') }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
