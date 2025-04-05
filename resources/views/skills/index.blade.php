<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Skills Directory') }}
            </h2>
            <a href="{{ route('skills.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                {{ __('Add New Skill') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-100 to-indigo-200 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6 border border-gray-200 dark:border-gray-700 transition-all duration-300">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Search Skills') }}</label>
                        <input type="text" id="search" placeholder="Search by name..." class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200">
                    </div>
                    <div class="sm:w-48">
                        <label for="category-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Filter by Category') }}</label>
                        <select id="category-filter" class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-colors duration-200">
                            <option value="all">{{ __('All Categories') }}</option>
                            @php
                                $categories = \App\Models\Skill::select('category')->distinct()->pluck('category');
                            @endphp
                            @foreach($categories as $category)
                                @if($category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Skills List with Animation -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 animate-fadeIn">
                @forelse($skills as $skill)
                    <div class="skill-card bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1" 
                         data-category="{{ $skill->category }}"
                         data-name="{{ $skill->name }}">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-900 px-4 py-2 text-white font-semibold">
                            {{ $skill->category ?: 'General' }}
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ $skill->name }}</h3>
                            
                            <div class="mt-4 flex justify-between items-center">
                                @if(in_array($skill->id, $userSkills))
                                    <form action="{{ route('skills.removeFromProfile', $skill) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white rounded-md text-sm transition-colors duration-200">
                                            {{ __('Remove Skill') }}
                                        </button>
                                    </form>
                                    <a href="{{ route('skills.show', $skill) }}" class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors duration-200">
                                        {{ __('Details') }}
                                    </a>
                                @else
                                    <button type="button" onclick="showProficiencyModal('{{ $skill->id }}', '{{ $skill->name }}')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md text-sm transition-colors duration-200">
                                        {{ __('Add to Profile') }}
                                    </button>
                                    <a href="{{ route('skills.show', $skill) }}" class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors duration-200">
                                        {{ __('Details') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center border border-gray-200 dark:border-gray-700">
                        <p class="text-gray-500 dark:text-gray-400">{{ __('No skills found. Be the first to add a skill!') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Proficiency Modal -->
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
        // Skill filtering
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const categoryFilter = document.getElementById('category-filter');
            const skillCards = document.querySelectorAll('.skill-card');
            
            function filterSkills() {
                const searchTerm = searchInput.value.toLowerCase();
                const category = categoryFilter.value;
                
                skillCards.forEach(card => {
                    const skillName = card.dataset.name.toLowerCase();
                    const skillCategory = card.dataset.category;
                    
                    const matchesSearch = skillName.includes(searchTerm);
                    const matchesCategory = category === 'all' || skillCategory === category;
                    
                    if (matchesSearch && matchesCategory) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            }
            
            searchInput.addEventListener('input', filterSkills);
            categoryFilter.addEventListener('change', filterSkills);
        });
        
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
    
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</x-app-layout>