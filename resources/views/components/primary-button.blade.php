<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary transform hover:scale-105 transition-all duration-300']) }}>
    {{ $slot }}
</button>
