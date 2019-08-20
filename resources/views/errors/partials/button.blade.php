<a href="{{ app('router')->has('home') ? route('home') : url('/') }}">
    <button class="bg-transparent text-grey-darkest font-bold uppercase tracking-wide py-3 px-6 border-2 border-grey-light hover:border-grey rounded-lg">
        {{ __('Go Home') }}
    </button>
</a>
