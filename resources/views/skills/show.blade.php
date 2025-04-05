<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $skill->name }}
            </h2>
            <a href="{{ route('skills.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded transition-colors duration-200">
                {{ __('Back to Skills') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-100 to-indigo-200 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 transition-all duration-300">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-900 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $skill->name }}</h3>
                            <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                                {{ $skill->category ?: 'General' }}
                            </div>
                        </div>
                        
                        @if(Auth::user()->skills->contains($skill))
                            <div class="mt-4 md:mt-0 flex items-center">
                                <span class="text-white mr-3">{{ __('Your proficiency:') }}</span>
                                <div class="flex">
                                    @php
                                        $userProficiency = Auth::user()->skills->find($skill->id)->pivot->proficiency_level;
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="w-6 h-6 rounded-full {{ $i <= $userProficiency ? 'bg-yellow-400' : 'bg-gray-300 bg-opacity-30' }} flex items-center justify-center mx-0.5">
                                            @if($i <= $userProficiency)
                                                <svg class="w-4 h-4 text-yellow-800" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else
                                                <span class="text-white text-xs">{{ $i }}</span>
                                            @endif
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @else
                            <button onclick="showProficiencyModal('{{ $skill->id }}', '{{ $skill->name }}')" class="mt-4 md:mt-0 bg-white text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-medium px-4 py-2 rounded-md text-sm transition-all duration-200 transform hover:scale-105">
                                {{ __('Add to Your Profile') }}
                            </button>
                        @endif
                    </div>
                </div>
                
                <!-- People with this skill section -->
                <div class="p-6">
                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{ __('People with this skill') }}</h4>
                    
                    @if($users->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($users as $user)
                                <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 border border-gray-200 dark:border-gray-600 transition-all duration-300 hover:shadow-md">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-semibold text-xl">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h5 class="text-lg font-medium text-gray-900 dark:text-white">{{ $user->name }}</h5>
                                            <div class="mt-1 flex items-center">
                                                <span class="text-xs text-gray-500 dark:text-gray-400 mr-2">{{ __('Proficiency:') }}</span>
                                                <div class="flex">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <div class="w-4 h-4 rounded-full {{ $i <= $user->pivot->proficiency_level ? 'bg-yellow-400' : 'bg-gray-300 dark:bg-gray-600' }} mx-0.5"></div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No users have added this skill to their profile yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Proficiency Modal (same as in index.blade.php) -->
    <div id="proficiencyModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Add Skill to Profile') }}</h3>
            <p class="mb-4 text-gray-600 dark:text-gray-400">{{ __('How would you rate your proficiency in') }} <span id="skillName"></span>?</p>
            
            <form action="{{ route('skills.addToProfile') }}" method="POST">
                @csrf
                <input type="hidden" name="skill_id" id="skillId">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Proficiency Level') }}</label>
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
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md transition-colors duration-200">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md transition-colors duration-200">
                        {{ __('Add Skill') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Modal functionality
        function showProficiencyModal(skillId, skillName) {
            const modal = document.getElementById('proficiencyModal');
            const modalContent = document.getElementById('modalContent');
            document.getElementById('skillId').value = skillId;
            document.getElementById('skillName').textContent = skillName;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function closeModal() {
            const modal = document.getElementById('proficiencyModal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</x-app-layout>