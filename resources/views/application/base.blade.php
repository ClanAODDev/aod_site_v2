<!DOCTYPE html>
<html lang="en">

@include('application.header')
<script type="text/javascript">
    let AOD = {"path": "{{ config('app_url') }}"};
</script>
<script src="{{ asset('js/app.js') }}"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<body class="{{ request()->is('history') ? 'page-template-page-history' : null }}">
@include('partials.dev-banner')

@include('partials.apply')

@if(request()->is('/'))
    <div class="push" style="margin-top: 700px;"></div>
@endif

@include('partials.nav-bar')

@yield('content')

@include('application.footer')

<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
