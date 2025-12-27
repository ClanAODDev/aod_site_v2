<!DOCTYPE html>
<html lang="en">

@include('application.header')
<body class="{{ request()->is('history') ? 'page-template-page-history' : null }}">
@include('partials.dev-banner')

@include('partials.apply')

@if(request()->is('/'))
    <div class="push"></div>
@endif

@include('partials.nav-bar')

<main class="main-content">
@yield('content')
</main>

@include('application.footer')

@vite(['resources/js/app.js'])

</body>
</html>
