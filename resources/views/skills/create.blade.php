<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add New Skill') }}
            </h2>
            <a href="{{ route('skills.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded transition-colors duration-200">
                {{ __('Back to Skills') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-100 to-indigo-200 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 transition-all duration-300">
                <form method="POST" action="{{ route('skills.store') }}">
                    @csrf
                    <div class="p-6">
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('Skill Name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('Category') }}
                            </label>
                            <select name="category" id="category" 
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200">
                                <option value="">{{ __('-- Select Category --') }}</option>
                                <option value="Programming" {{ old('category') == 'Programming' ? 'selected' : '' }}>{{ __('Programming') }}</option>
                                <option value="Design" {{ old('category') == 'Design' ? 'selected' : '' }}>{{ __('Design') }}</option>
                                <option value="Database" {{ old('category') == 'Database' ? 'selected' : '' }}>{{ __('Database') }}</option>
                                <option value="Project Management" {{ old('category') == 'Project Management' ? 'selected' : '' }}>{{ __('Project Management') }}</option>
                                <option value="Communication" {{ old('category') == 'Communication' ? 'selected' : '' }}>{{ __('Communication') }}</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="add_to_profile" id="add_to_profile" value="1" {{ old('add_to_profile', '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 dark:text-indigo-500 shadow-sm focus:border-indigo-300 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600 focus:ring-opacity-50 transition-colors duration-200">
                                <label for="add_to_profile" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    {{ __('Add this skill to my profile immediately') }}
                                </label>
                            </div>
                        </div>
                        
                        <div id="proficiency-section" class="mb-6 {{ old('add_to_profile', '1') ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('Proficiency Level') }}
                            </label>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Beginner') }}</span>
                                <div class="flex items-center space-x-1 mx-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="proficiency_level" value="{{ $i }}" class="sr-only peer" {{ $i == 3 ? 'checked' : '' }}>
                                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500 text-white transition-colors duration-200">
                                                {{ $i }}
                                            </div>
                                        </label>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Expert') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                        <a href="{{ route('skills.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md transition-colors duration-200">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                            {{ __('Create Skill') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToProfileCheckbox = document.getElementById('add_to_profile');
            const proficiencySection = document.getElementById('proficiency-section');
            
            addToProfileCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    proficiencySection.classList.remove('hidden');
                } else {
                    proficiencySection.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>