<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-secondary hover:shadow-md transition-all duration-300']) }}>
    {{ $slot }}
</button>
