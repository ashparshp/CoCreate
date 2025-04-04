@props(['status', 'type' => 'default'])

@php
$colors = [
    'default' => [
        'planning' => 'bg-secondary-100 text-secondary-800 dark:bg-secondary-700/60 dark:text-secondary-300',
        'in_progress' => 'bg-primary-100 text-primary-800 dark:bg-primary-900/60 dark:text-primary-300',
        'completed' => 'bg-success-100 text-success-800 dark:bg-success-900/60 dark:text-success-300',
        'on_hold' => 'bg-warning-100 text-warning-800 dark:bg-warning-900/60 dark:text-warning-300',
    ],
    'task' => [
        'to_do' => 'bg-secondary-100 text-secondary-800 dark:bg-secondary-700/60 dark:text-secondary-300',
        'in_progress' => 'bg-primary-100 text-primary-800 dark:bg-primary-900/60 dark:text-primary-300',
        'review' => 'bg-warning-100 text-warning-800 dark:bg-warning-900/60 dark:text-warning-300',
        'completed' => 'bg-success-100 text-success-800 dark:bg-success-900/60 dark:text-success-300',
    ],
    'priority' => [
        'low' => 'bg-success-100 text-success-800 dark:bg-success-900/60 dark:text-success-300',
        'medium' => 'bg-warning-100 text-warning-800 dark:bg-warning-900/60 dark:text-warning-300',
        'high' => 'bg-danger-100 text-danger-800 dark:bg-danger-900/60 dark:text-danger-300',
    ],
    'role' => [
        'owner' => 'bg-info-100 text-info-800 dark:bg-info-900/60 dark:text-info-300',
        'member' => 'bg-primary-100 text-primary-800 dark:bg-primary-900/60 dark:text-primary-300',
        'pending' => 'bg-warning-100 text-warning-800 dark:bg-warning-900/60 dark:text-warning-300',
    ],
    'visibility' => [
        '1' => 'bg-success-100 text-success-800 dark:bg-success-900/60 dark:text-success-300',
        'true' => 'bg-success-100 text-success-800 dark:bg-success-900/60 dark:text-success-300',
        '0' => 'bg-secondary-100 text-secondary-800 dark:bg-secondary-700/60 dark:text-secondary-300',
        'false' => 'bg-secondary-100 text-secondary-800 dark:bg-secondary-700/60 dark:text-secondary-300',
    ]
];

$typeMap = $colors[$type] ?? $colors['default'];
$colorClass = $typeMap[$status] ?? 'bg-secondary-100 text-secondary-800 dark:bg-secondary-700/60 dark:text-secondary-300';

// Format the status label
$label = ucfirst(str_replace('_', ' ', $status));
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$colorClass}"]) }}>
    {{ $slot ?? $label }}
</span>
