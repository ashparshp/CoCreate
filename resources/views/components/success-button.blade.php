<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-success transform hover:scale-105 transition-all duration-300']) }}>
    {{ $slot }}
</button>
