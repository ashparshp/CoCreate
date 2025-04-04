<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-secondary-800 dark:text-secondary-200 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-secondary-900 dark:text-secondary-100">{{ __('Profile Information') }}</h3>
                        <p class="mt-1 text-sm text-secondary-600 dark:text-secondary-400">
                            {{ __('Your personal information and skills.') }}
                        </p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn-primary">
                        {{ __('Edit Profile') }}
                    </a>
                </div>

                <div class="mt-4">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-secondary-500 dark:text-secondary-400">{{ __('Name') }}</dt>
                            <dd class="mt-1 text-sm text-secondary-900 dark:text-secondary-100">{{ $user->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-secondary-500 dark:text-secondary-400">{{ __('Email') }}</dt>
                            <dd class="mt-1 text-sm text-secondary-900 dark:text-secondary-100">{{ $user->email }}</dd>
                        </div>
                    </dl>
                </div>
            </x-card>

            <div class="mt-6">
                <x-card>
                    <h3 class="text-lg font-medium text-secondary-900 dark:text-secondary-100 mb-4">{{ __('Skills & Expertise') }}</h3>

                    @if(isset($skills) && $skills->count() > 0)
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 dark:ring-white dark:ring-opacity-10 md:rounded-lg mb-4">
                            <table class="min-w-full divide-y divide-secondary-200 dark:divide-secondary-700">
                                <thead class="bg-secondary-50 dark:bg-secondary-800/80">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-secondary-900 dark:text-secondary-100">{{ __('Skill') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-secondary-900 dark:text-secondary-100">{{ __('Category') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-secondary-900 dark:text-secondary-100">{{ __('Proficiency') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-secondary-200 dark:divide-secondary-700 bg-white dark:bg-secondary-800">
                                    @foreach($skills as $skill)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-secondary-900 dark:text-secondary-100">{{ $skill->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-secondary-500 dark:text-secondary-400">{{ $skill->category ?: __('General') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-secondary-500 dark:text-secondary-400">
                                                <div class="flex items-center">
                                                    <div class="flex h-2 w-24 bg-secondary-200 dark:bg-secondary-700 rounded-full overflow-hidden">
                                                        <div class="bg-primary-500 dark:bg-primary-600 h-full" style="width: {{ ($skill->pivot->proficiency_level / 5) * 100 }}%"></div>
                                                    </div>
                                                    <span class="ml-2">{{ $skill->pivot->proficiency_level }}/5</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-warning-50 dark:bg-warning-900/20 p-4 rounded border border-warning-200 dark:border-warning-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-warning-400 dark:text-warning-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-warning-800 dark:text-warning-200">{{ __('No skills added yet') }}</h3>
                                    <div class="mt-2 text-sm text-warning-700 dark:text-warning-300">
                                        <p>{{ __('Add skills to your profile to help others find you for project collaborations.') }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-warning-800 dark:text-warning-200 hover:text-warning-700 dark:hover:text-warning-300">
                                            {{ __('Add skills now') }} <span aria-hidden="true">&rarr;</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
