<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-emerald-700 hover:to-emerald-800 focus:from-emerald-700 focus:to-emerald-800 active:from-emerald-800 active:to-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
