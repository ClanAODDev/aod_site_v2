<meta data-rh="true" name="title" content="ClanAOD.net | @yield('page-title', 'Angels of Death')">
<meta data-rh="true" property="og:title" content="ClanAOD.net | @yield('page-title', 'Angels of Death')">
<meta data-rh="true" property="twitter:title" content="ClanAOD.net | @yield('page-title', 'Angels of Death')">

<?php
// Inlining this for DRY purposes
$description = 'The Angels of Death is a community of players founded in 1999 based on a core set of conduct that aims to promote decency and provide a comfortable environment to play with thousands of other likeminded members.';
?>

<meta data-rh="true" name="description" content="@yield('og-description', $description)">
<meta data-rh="true" property="og:description" content="@yield('og-description', $description)">
<meta data-rh="true" property="twitter:description" content="@yield('og-description', $description)">
<meta data-rh="true" property="og:image" content="@yield('og-image', asset('images/official-logo.png'))">


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
