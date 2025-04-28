@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden animate-fadeIn" style="animation-delay: 0.1s;">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 dark:bg-indigo-700 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalUsers }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden animate-fadeIn" style="animation-delay: 0.2s;">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 dark:bg-purple-700 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Projects</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalProjects }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden animate-fadeIn" style="animation-delay: 0.3s;">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 dark:bg-green-700 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tasks</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalTasks }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden animate-fadeIn" style="animation-delay: 0.4s;">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 dark:bg-yellow-700 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Skills</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalSkills }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden animate-fadeIn" style="animation-delay: 0.5s;">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 dark:bg-blue-700 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Files</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalFiles }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project Status Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Projects by Status</h3>
                    </div>
                    <div class="p-5">
                        <div class="relative h-64">
                            <canvas id="projectStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Projects</h3>
                    </div>
                    <div class="p-5">
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($recentProjects as $project)
                                <li class="py-3">
                                    <div class="flex justify-between">
                                        <div>
                                            <a href="{{ route('admin.projects.show', $project) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium transition-colors duration-200">
                                                {{ $project->title }}
                                            </a>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Created {{ $project->created_at->diffForHumans() }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($project->status == 'planning') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @elseif($project->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Recent Users -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Users</h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        @foreach($recentUsers as $key => $user)
                            @php
                                $colors = [
                                    // Light mode gradient, avatar bg, text color, link color
                                    ['bg-gradient-to-br from-cyan-50 to-blue-100 dark:bg-gradient-to-br dark:from-blue-800 dark:to-cyan-900', 'bg-cyan-200 dark:bg-blue-600', 'text-cyan-700 dark:text-blue-200', 'text-cyan-600 dark:text-blue-300 hover:text-cyan-800 dark:hover:text-blue-100'],
                                    
                                    ['bg-gradient-to-br from-purple-50 to-fuchsia-100 dark:bg-gradient-to-br dark:from-purple-800 dark:to-fuchsia-900', 'bg-purple-200 dark:bg-purple-600', 'text-purple-700 dark:text-purple-200', 'text-purple-600 dark:text-purple-300 hover:text-purple-800 dark:hover:text-purple-100'],
                                    
                                    ['bg-gradient-to-br from-emerald-50 to-teal-100 dark:bg-gradient-to-br dark:from-teal-800 dark:to-emerald-900', 'bg-emerald-200 dark:bg-emerald-600', 'text-emerald-700 dark:text-emerald-200', 'text-emerald-600 dark:text-emerald-300 hover:text-emerald-800 dark:hover:text-emerald-100'],
                                    
                                    ['bg-gradient-to-br from-amber-50 to-orange-100 dark:bg-gradient-to-br dark:from-amber-800 dark:to-orange-900', 'bg-amber-200 dark:bg-amber-600', 'text-amber-700 dark:text-amber-200', 'text-amber-600 dark:text-amber-300 hover:text-amber-800 dark:hover:text-amber-100'],
                                    
                                    ['bg-gradient-to-br from-rose-50 to-pink-100 dark:bg-gradient-to-br dark:from-pink-800 dark:to-rose-900', 'bg-rose-200 dark:bg-rose-600', 'text-rose-700 dark:text-pink-200', 'text-rose-600 dark:text-pink-300 hover:text-rose-800 dark:hover:text-pink-100'],
                                ];
                                $colorSet = $colors[$key % count($colors)];
                            @endphp
                            <div class="{{ $colorSet[0] }} rounded-lg p-4 text-center shadow hover:shadow-md transition-all duration-300 transform hover:scale-105 dark:border dark:border-gray-700">
                                <div class="mx-auto h-16 w-16 rounded-full {{ $colorSet[1] }} flex items-center justify-center {{ $colorSet[2] }} text-xl font-bold shadow-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <h4 class="mt-2 font-medium text-gray-900 dark:text-gray-100 truncate">{{ $user->name }}</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-300">Joined {{ $user->created_at->diffForHumans() }}</p>
                                <a href="{{ route('admin.users.show', $user) }}" class="mt-2 inline-block text-xs {{ $colorSet[3] }} transition-colors duration-200">
                                    View Profile
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Links</h3>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.users.index') }}" class="bg-gradient-to-r from-indigo-600 to-indigo-800 hover:from-indigo-700 hover:to-indigo-900 text-white rounded-lg p-4 shadow-md transition-all duration-300 hover:shadow-lg transform hover:scale-105">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-indigo-100">Manage Users</h4>
                                <p class="text-xs text-indigo-100">View, edit and manage users</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.projects.index') }}" class="bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white rounded-lg p-4 shadow-md transition-all duration-300 hover:shadow-lg transform hover:scale-105">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-indigo-100">Manage Projects</h4>
                                <p class="text-xs text-purple-100">Monitor and control projects</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.skills.index') }}" class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white rounded-lg p-4 shadow-md transition-all duration-300 hover:shadow-lg transform hover:scale-105">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-indigo-100">Manage Skills</h4>
                                <p class="text-xs text-blue-100">Add, edit or remove skills</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.settings') }}" class="bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-800 hover:to-black text-white rounded-lg p-4 shadow-md transition-all duration-300 hover:shadow-lg transform hover:scale-105">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-indigo-100">System Settings</h4>
                                <p class="text-xs text-gray-300">Configure application settings</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup project status chart
            const projectStatusChart = document.getElementById('projectStatusChart');
            
            const statusData = {
                labels: ['Planning', 'In Progress', 'Completed', 'On Hold'],
                datasets: [{
                    label: 'Projects by Status',
                    data: [
                        {{ $projectsByStatus['planning'] }}, 
                        {{ $projectsByStatus['in_progress'] }}, 
                        {{ $projectsByStatus['completed'] }}, 
                        {{ $projectsByStatus['on_hold'] }}
                    ],
                    backgroundColor: [
                        'rgba(156, 163, 175, 0.8)',  // gray
                        'rgba(59, 130, 246, 0.8)',   // blue
                        'rgba(16, 185, 129, 0.8)',   // green
                        'rgba(245, 158, 11, 0.8)'    // yellow
                    ],
                    borderColor: [
                        'rgb(156, 163, 175)',
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)'
                    ],
                    borderWidth: 1
                }]
            };
            
            new Chart(projectStatusChart, {
                type: 'pie',
                data: statusData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? 'white' : 'rgb(55, 65, 81)',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
