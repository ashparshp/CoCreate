@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'bg-danger-50 dark:bg-danger-900/30 p-4 rounded-md border border-danger-200 dark:border-danger-800']) }}>
        <div class="font-medium text-danger-600 dark:text-danger-400">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-danger-600 dark:text-danger-400">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif