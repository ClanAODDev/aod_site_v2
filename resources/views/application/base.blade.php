<!DOCTYPE html>
<html lang="en">

@include('application.header')
<script type="text/javascript">
    let AOD = {"path": "{{ config('app_url') }}"};
</script>
<script src="{{ asset('js/app.js') }}"></script>


<body class="{{ request()->is('history') ? 'page-template-page-history' : null }}">

@include('partials.apply')

@if(request()->is('/'))
    <div class="commo-bar">
        <p class="commo-item"><i class="fab fa-teamspeak fa-lg"></i>
            <strong>TEAMSPEAK </strong> 50 / 340
        </p>
        <p class="commo-item">
            <i class="fab fa-discord fa-lg"></i>
            <strong>DISCORD</strong> {{ 50 + 39 + 12 }} / {{ 390 }}
        </p>
    </div>
    <div class="push" style="margin-top: 700px;"></div>
@endif

@include('partials.nav-bar')

@yield('content')

@include('application.footer')

<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
