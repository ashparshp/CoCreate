<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-danger transform hover:scale-105 transition-all duration-300']) }}>
    {{ $slot }}
</button>
