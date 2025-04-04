@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-success-600 dark:text-success-400 bg-success-50 dark:bg-success-900/30 p-3 rounded-md border border-success-200 dark:border-success-800']) }}>
        {{ $status }}
    </div>
@endif
