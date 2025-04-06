<section id="skills">
    <div class="mt-6">
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('Your Current Skills') }}</h3>
            </div>
            
            @if(auth()->user()->skills->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(auth()->user()->skills as $skill)
                        <div class="relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                                <div class="absolute transform rotate-45 bg-indigo-100 dark:bg-indigo-900/20 text-indigo-800 dark:text-indigo-300 w-24 h-6 right-[-5px] top-[18px] text-center text-xs"></div>
                            </div>
                            
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $skill->name }}</h4>
                                    
                                    @php
                                        $categoryHash = crc32($skill->category ?? 'General');
                                        $colorIndex = abs($categoryHash) % 5;
                                        $colors = ['indigo', 'blue', 'purple', 'teal', 'rose'];
                                        $color = $colors[$colorIndex];
                                    @endphp
                                    
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        bg-{{ $color }}-100 
                                        text-{{ $color }}-800 
                                        dark:bg-{{ $color }}-900/30
                                        dark:text-{{ $color }}-300
                                        dark:border dark:border-{{ $color }}-700/50
                                        mt-1">
                                        {{ $skill->category ?: __('General') }}
                                    </span>
                                </div>
                                
                                <div class="relative">
                                    <button type="button" onclick="toggleDropdown('dropdown-{{ $skill->id }}')" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 focus:outline-none" aria-label="Skill options">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('skills.removeFromProfile', $skill) }}" method="POST" id="dropdown-{{ $skill->id }}" class="hidden absolute right-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-600">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md" 
                                               onclick="openRemoveSkillModal('{{ $skill->id }}', '{{ $skill->name }}', this.closest('form'))">
                                            {{ __('Remove from profile') }}
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="mt-3 mb-4">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Your Proficiency') }}</span>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="w-4 h-4 rounded-full mx-0.5 {{ $i <= $skill->pivot->proficiency_level ? 'bg-indigo-500 dark:bg-indigo-400 shadow-sm shadow-indigo-200 dark:shadow-indigo-900/30' : 'bg-gray-200 dark:bg-gray-600' }}"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <form action="{{ route('skills.addToProfile') }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <input type="hidden" name="skill_id" value="{{ $skill->id }}">
                                    <div class="flex-1">
                                        <select name="proficiency_level" class="block w-full text-sm border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300">
                                            @for($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ $skill->pivot->proficiency_level == $i ? 'selected' : '' }}>
                                                    {{ $i }} - {{ $i == 1 ? __('Beginner') : ($i == 3 ? __('Intermediate') : ($i == 5 ? __('Expert') : '')) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-sm transition duration-150">
                                        {{ __('Update') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 px-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-500 dark:text-indigo-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <p class="text-base font-medium text-gray-900 dark:text-gray-100 mb-1">{{ __("You haven't added any skills yet") }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ __("Adding skills helps you get discovered for the right projects") }}</p>
                    <a href="{{ route('skills.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        {{ __('Browse Skills Directory') }}
                    </a>
                </div>
            @endif
        </div>
        
        <div class="mt-10 mb-8">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center text-white mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('Add Skills to Your Profile') }}</h3>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Add skills to showcase your expertise and increase your visibility.') }}</p>
                <a href="{{ route('skills.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 border border-transparent rounded-md text-xs font-medium text-white shadow-sm hover:shadow-md transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    {{ __('Browse All Skills') }}
                </a>
            </div>
            
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/10 dark:to-teal-900/10 rounded-lg p-5 border border-emerald-100 dark:border-emerald-900/20 shadow-sm">
                <h4 class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-4">{{ __('Recently Added Skills') }}</h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @php
                        $userSkillIds = auth()->user()->skills->pluck('id')->toArray();
                        $availableSkills = DB::table('skills')
                            ->whereNotIn('id', $userSkillIds)
                            ->orderBy('created_at', 'desc')
                            ->limit(9)
                            ->get();
                    @endphp
                    
                    @forelse($availableSkills as $skill)
                        <div class="group p-3 border border-emerald-200 dark:border-emerald-800 rounded-lg bg-white dark:bg-gray-800 hover:shadow-md transition duration-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $skill->name }}</p>
                                    
                                    @php
                                        $categoryHash = crc32($skill->category ?? 'General');
                                        $colorIndex = abs($categoryHash) % 5;
                                        $colors = ['indigo', 'blue', 'purple', 'teal', 'rose'];
                                        $color = $colors[$colorIndex];
                                    @endphp
                                    
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        bg-{{ $color }}-100 
                                        text-{{ $color }}-800 
                                        dark:bg-{{ $color }}-900/30
                                        dark:text-{{ $color }}-300
                                        dark:border dark:border-{{ $color }}-700/50">
                                        {{ $skill->category ?: __('General') }}
                                    </span>
                                </div>
                                <button type="button" 
                                        onclick="openProficiencyModal('{{ $skill->id }}', '{{ $skill->name }}')"
                                        class="text-xs px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-md shadow-sm group-hover:shadow transition duration-200">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-4 text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No additional skills available. Why not create a new one?') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="mt-10 pt-8 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-500 to-amber-600 flex items-center justify-center text-white mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('Create New Skill') }}</h3>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __("Can't find the skill you're looking for? Add it to our directory.") }}</p>
                <a href="{{ route('skills.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 border border-transparent rounded-md text-xs font-medium text-white shadow-sm hover:shadow-md transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('Create New Skill') }}
                </a>
            </div>
            
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/10 dark:to-amber-900/10 p-5 rounded-lg border border-orange-100 dark:border-orange-900/20 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            {{ __('Creating a new skill will make it available for all users. Please ensure it doesn\'t already exist in our directory.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(event.target) && 
                    !event.target.closest(`button[onclick*="${dropdown.id}"]`)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
            allDropdowns.forEach(item => {
                if (item.id !== dropdownId) {
                    item.classList.add('hidden');
                }
            });
            dropdown.classList.toggle('hidden');
            event.stopPropagation();
        }
    </script>
</section>

<div id="proficiencyModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 backdrop-blur-sm hidden">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <div class="mb-5">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Add Skill to Profile') }}</h3>
            <p class="text-gray-600 dark:text-gray-400">{{ __('How would you rate your proficiency in') }} <span id="skillName" class="font-medium text-indigo-600 dark:text-indigo-400"></span>?</p>
        </div>
        
        <form action="{{ route('skills.addToProfile') }}" method="POST">
            @csrf
            <input type="hidden" name="skill_id" id="skillId">
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('Proficiency Level') }}</label>
                
                <div class="flex flex-col space-y-4">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="relative flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                            <input type="radio" name="proficiency_level" value="{{ $i }}" class="h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" {{ $i == 3 ? 'checked' : '' }}>
                            <div class="ml-3">
                                <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ __('Level') }} {{ $i }}</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400">
                                    @if($i == 1)
                                        {{ __('Beginner - Basic understanding and limited experience') }}
                                    @elseif($i == 2)
                                        {{ __('Advanced Beginner - Growing knowledge with some practical experience') }}
                                    @elseif($i == 3)
                                        {{ __('Intermediate - Solid practical knowledge and regular application') }}
                                    @elseif($i == 4)
                                        {{ __('Advanced - Deep understanding and extensive experience') }}
                                    @elseif($i == 5)
                                        {{ __('Expert - Mastery level with the ability to innovate and teach others') }}
                                    @endif
                                </span>
                            </div>
                        </label>
                    @endfor
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-colors duration-200">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    {{ __('Add Skill') }}
                </button>
            </div>
        </form>
    </div>
</div>

<div id="removeSkillModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 backdrop-blur-sm hidden">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="removeModalContent">
        <div class="mb-5">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Remove Skill') }}</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400">{{ __('Are you sure you want to remove') }} <span id="removeSkillName" class="font-medium text-red-600 dark:text-red-400"></span> {{ __('from your profile?') }}</p>
        </div>
        
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30 rounded-lg p-4 mb-5">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 dark:text-red-300">
                        {{ __('This action cannot be undone. The skill will be removed from your profile but will remain in the skills directory.') }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" onclick="closeRemoveModal()" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-colors duration-200">
                {{ __('Cancel') }}
            </button>
            <button type="button" id="confirmRemoveBtn" class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                {{ __('Remove Skill') }}
            </button>
        </div>
        
        <div id="removeFormContainer" class="hidden"></div>
    </div>
</div>

<script>
    function openProficiencyModal(skillId, skillName) {
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
    
    function openRemoveSkillModal(skillId, skillName, formElement) {
        const modal = document.getElementById('removeSkillModal');
        const modalContent = document.getElementById('removeModalContent');
        const formContainer = document.getElementById('removeFormContainer');
        const confirmBtn = document.getElementById('confirmRemoveBtn');
        document.getElementById('removeSkillName').textContent = skillName;
        formContainer.innerHTML = '';
        const formClone = formElement.cloneNode(true);
        formContainer.appendChild(formClone);
        confirmBtn.onclick = function() {
            const form = formContainer.querySelector('form');
            if (form) {
                form.submit();
            }
        };
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function closeRemoveModal() {
        const modal = document.getElementById('removeSkillModal');
        const modalContent = document.getElementById('removeModalContent');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
