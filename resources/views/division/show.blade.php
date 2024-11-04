@extends ('application.base')

@section('page-title', "{$data['division']['name']} Division")
@section('og-image', $data['division']['icon'])

@section('content')

    <section class="division" data-application-id="{{ $data['division']['forum_app_id'] }}"
             style="background: url({{ asset("images/division-headers/{$data['division']['abbreviation']}.jpg") }}) no-repeat, url({{ asset('images/division-bg-border.jpg') }}) repeat-x; background-position: top center;">
        <div class="section-content-container">
            <div id="sub-nav"></div>

            <div id="general" class="game-header">
                <div class="icon">
                    <img class="game" src="{{ $data['division']['icon'] }}"/>
                </div>
                <h1>{{ $data['division']['name'] }} Division</h1>
            </div>

            @includeIf("division.content.{$data['division']['slug']}", compact('division'))

            <p style="text-align: center; margin-bottom:50px;">
                <a class="call-to-action-button" style="margin:10px;" href="https://www.clanaod.net/forums/register.php">1. Create Account</a>
                <a class="call-to-action-button" style="margin:10px;" href="#" data-application-link="">2. Apply for division</a>
            </p>
        </div>
    </section>

@endsection
