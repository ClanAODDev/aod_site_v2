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
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Rajdhani:wght@300;700&display=swap" rel="stylesheet">
    @vite(['resources/js/app.tsx'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
