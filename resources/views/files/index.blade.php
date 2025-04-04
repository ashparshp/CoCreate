<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Files') }} - {{ $project->title }}
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
            <!-- File Upload -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Upload New File') }}</h3>
                    
                    <form action="{{ route('projects.files.upload', $project) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-center">
                            <input type="file" name="file" id="file" 
                                   class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-200 hover:file:bg-blue-100 dark:hover:file:bg-blue-800"
                                   required onchange="previewFile()">
                            <button type="submit" class="ml-2 bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 text-white px-4 py-2 rounded">
                                {{ __('Upload') }}
                            </button>
                        </div>
                        <div id="file-preview" class="mt-2"></div>
                    </form>
                </div>
            </div>

            <!-- File Browser -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Project Files') }}</h3>
                        
                        <div class="flex items-center">
                            <input type="text" id="file-search" placeholder="{{ __('Search files...') }}" 
                                   class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50">
                            
                            <select id="file-type-filter" 
                                    class="ml-2 rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm focus:border-blue-300 dark:focus:border-blue-400 focus:ring focus:ring-blue-200 dark:focus:ring-blue-600 focus:ring-opacity-50">
                                <option value="all">{{ __('All Types') }}</option>
                                <option value="image">{{ __('Images') }}</option>
                                <option value="document">{{ __('Documents') }}</option>
                                <option value="spreadsheet">{{ __('Spreadsheets') }}</option>
                                <option value="presentation">{{ __('Presentations') }}</option>
                                <option value="archive">{{ __('Archives') }}</option>
                                <option value="other">{{ __('Other') }}</option>
                            </select>
                        </div>
                    </div>
                    
                    @if($files->isEmpty())
                        <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded flex flex-col items-center justify-center border border-gray-200 dark:border-gray-700">
                            <svg class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 mb-2">{{ __('No files uploaded yet') }}</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500">{{ __('Upload files to share with your team') }}</p>
                        </div>
                    @else
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 dark:ring-white dark:ring-opacity-10 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">{{ __('File') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">{{ __('Type') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">{{ __('Size') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">{{ __('Uploaded By') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">{{ __('Date') }}</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">{{ __('Actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800" id="file-list">
                                    @foreach($files as $file)
                                        @php
                                        $fileTypeClass = '';
                                        $fileTypeIcon = '';
                                        $fileTypeLabel = '';
                                        $fileCategory = 'other';

                                        // Determine file type for filtering and display
                                        if (preg_match('/^image\//', $file->filetype)) {
                                            $fileTypeClass = 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200';
                                            $fileTypeIcon = '<svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>';
                                            $fileTypeLabel = __('Image');
                                            $fileCategory = 'image';
                                        } 
                                        elseif (preg_match('/pdf/', $file->filetype)) {
                                            $fileTypeClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                            $fileTypeIcon = '<svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>';
                                            $fileTypeLabel = __('PDF');
                                            $fileCategory = 'document';
                                        } 
                                        elseif (preg_match('/document|msword|wordprocessing/', $file->filetype)) {
                                            $fileTypeClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                            $fileTypeIcon = '<svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
                                            $fileTypeLabel = __('Document');
                                            $fileCategory = 'document';
                                        } 
                                        elseif (preg_match('/spreadsheet|excel/', $file->filetype)) {
                                            $fileTypeClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                            $fileTypeIcon = '<svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
                                            $fileTypeLabel = __('Spreadsheet');
                                            $fileCategory = 'spreadsheet';
                                        } 
                                        elseif (preg_match('/presentation|powerpoint/', $file->filetype)) {
                                            $fileTypeClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200';
                                            $fileTypeIcon = '<svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>';
                                            $fileTypeLabel = __('Presentation');
                                            $fileCategory = 'presentation';
                                        } 
                                        elseif (preg_match('/zip|archive|compressed/', $file->filetype)) {
                                            $fileTypeClass = 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200';
                                            $fileTypeIcon = '<svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>';
                                            $fileTypeLabel = __('Archive');
                                            $fileCategory = 'archive';
                                        } 
                                        else {
                                            $fileTypeClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                            $fileTypeIcon = '<svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>';
                                            $fileTypeLabel = __('File');
                                            $fileCategory = 'other';
                                        }
                                        @endphp
                                        <tr class="file-item" data-filename="{{ $file->filename }}" data-type="{{ $fileCategory }}">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm">
                                                <div class="flex items-center">
                                                    <span class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                                                        @if(preg_match('/^image\//', $file->filetype))
                                                            <img src="{{ asset('storage/' . $file->filepath) }}" class="h-8 w-8 object-cover rounded" alt="{{ $file->filename }}">
                                                        @else
                                                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                            </svg>
                                                        @endif
                                                    </span>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $file->filename }}</div>
                                                        @if($file->task_id)
                                                            <div class="text-gray-500 dark:text-gray-400">
                                                                <a href="{{ route('projects.tasks.show', [$project, $file->task]) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                                                    {{ __('Task') }}: {{ $file->task->title }}
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $fileTypeClass }}">
                                                    {!! $fileTypeIcon !!}
                                                    {{ $fileTypeLabel }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ round($file->filesize / 1024, 2) }} KB
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $file->uploader->name }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $file->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a href="{{ route('projects.files.download', [$project, $file]) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3">
                                                    {{ __('Download') }}
                                                </a>
                                                
                                                @if($file->uploaded_by == Auth::id() || $project->creator_id == Auth::id())
                                                    <form action="{{ route('projects.files.destroy', [$project, $file]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this file?') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
