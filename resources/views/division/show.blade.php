@extends ('application.base')

@section('page-title', "{$data['division']['name']} Division")
@section('og-image', $data['division']['icon'])
@if (!empty($data['division']['settings']['meta_description']))
    @section('og-description', $data['division']['settings']['meta_description'])
@endif

@section('content')
    @php
        $division_abbr = $data['division']['abbreviation'];
        $division_image_path = public_path("images/division-headers/{$division_abbr}.jpg");
        $division_heading = file_exists($division_image_path) ? "images/division-headers/{$division_abbr}.jpg" : 'images/page-header.jpg';
    @endphp

    <section class="division" data-application-id="{{ $data['division']['forum_app_id'] }}"
             style="--division-header: url('{{ asset($division_heading) }}');">

        <div class="section-content-container">
            <div id="sub-nav"></div>

            <div id="general" class="game-header">
                <div class="icon">
                    <img class="game" src="{{ $data['division']['icon'] }}"/>
                </div>
                <h1>{{ $data['division']['name'] }} Division</h1>
            </div>

            <div class="division-actions">
                <a class="action-btn" href="https://www.clanaod.net/forums/register.php">Create Account</a>
                <a class="action-btn primary" href="#" data-application-link="">Apply Now</a>
            </div>

            <hr>
            @if($data['division']['site_content'])
                @markdown($data['division']['site_content'])
            @else
                <p>Division content coming soon.</p>
            @endif

            @include('partials.screenshot-gallery', ['screenshots' => $data['division']['screenshots'] ?? []])
        </div>
    </section>

@endsection
