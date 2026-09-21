<!DOCTYPE html>
<html lang="en" data-theme="tron">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ $metaTitle ?? 'Angels of Death Gaming Clan | Angels of Death' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'The Angels of Death is a community of players founded in 1999 based on a core set of conduct that aims to promote decency and provide a comfortable environment to play with thousands of other like-minded members.' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:site_name" content="Angels of Death">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? 'Angels of Death Gaming Clan | Angels of Death' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'The Angels of Death is a community of players founded in 1999 based on a core set of conduct that aims to promote decency and provide a comfortable environment to play with thousands of other like-minded members.' }}">
    <meta property="og:image" content="{{ $metaImage ?? asset('images/official-logo.png') }}">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="{{ $metaTitle ?? 'Angels of Death Gaming Clan | Angels of Death' }}">
    <meta property="twitter:description" content="{{ $metaDescription ?? 'The Angels of Death is a community of players founded in 1999 based on a core set of conduct that aims to promote decency and provide a comfortable environment to play with thousands of other like-minded members.' }}">
    @if (isset($structuredData))
        <script type="application/ld+json">{!! json_encode($structuredData) !!}</script>
    @endif
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/favicons/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('images/favicons/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Rajdhani:wght@300;700&display=swap" rel="stylesheet">
    @viteReactRefresh
    @vite(['resources/js/app.tsx'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
