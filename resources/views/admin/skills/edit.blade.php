@extends('layouts.admin')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Skill') }}
        </h2>
        <a href="{{ route('admin.skills.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded transition-colors duration-200">
            {{ __('Back to Skills') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Edit Skill Information') }}</h3>
                    </div>
                    
                    <div class="p-6">
                        <!-- Skill Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Skill Name') }}
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $skill->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200"
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Category') }}
                            </label>
                            <select name="category" id="category" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200">
                                <option value="">{{ __('Uncategorized') }}</option>
                                <option value="Programming" {{ old('category', $skill->category) == 'Programming' ? 'selected' : '' }}>{{ __('Programming') }}</option>
                                <option value="Design" {{ old('category', $skill->category) == 'Design' ? 'selected' : '' }}>{{ __('Design') }}</option>
                                <option value="Database" {{ old('category', $skill->category) == 'Database' ? 'selected' : '' }}>{{ __('Database') }}</option>
                                <option value="Project Management" {{ old('category', $skill->category) == 'Project Management' ? 'selected' : '' }}>{{ __('Project Management') }}</option>
                                <option value="Communication" {{ old('category', $skill->category) == 'Communication' ? 'selected' : '' }}>{{ __('Communication') }}</option>
                                <option value="Other" {{ old('category', $skill->category) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Usage Statistics -->
                        <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Usage Statistics') }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('This skill is used by') }} <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $skill->users->count() }}</span> {{ __('users') }}.
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ __('Created on') }} {{ $skill->created_at->format('F j, Y') }}.
                            </p>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                        <div>
                            <!-- Delete button moved outside the form but visually appears in the same position -->
                            <a href="#" onclick="event.preventDefault(); document.getElementById('delete-skill-form').submit();" 
                               class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                {{ __('Delete Skill') }}
                            </a>
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            {{ __('Update Skill') }}
                        </button>
                    </div>
                </form>
                
                <!-- Separate delete form outside the update form -->
                <form id="delete-skill-form" action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
@endsection