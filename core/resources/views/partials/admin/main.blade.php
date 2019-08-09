<main class="py-4">
    <div class="container-fluid">
        @if(auth()->check())
            <div class="row justify-content-center">
                @include('fp::partials.admin.sidebar')
                @include('fp::partials.admin.content')
            </div>
        @else
            @yield('content')
        @endif
    </div>
</main>