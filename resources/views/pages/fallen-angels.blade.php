@extends ('application.base')

@section('page-title', 'Fallen Angels')
@section('og-description', 'The Clan AOD community has a storied history, and through the years some have been lost.
This is our way of honoring their memory; May their souls rest in peace.')

@section('content')

    <section style="min-height: 800px;">
        <video src="{{ asset('images/memoriam-v2.webm') }}"
               preload="auto" loop playsinline muted autoplay
               style="margin-bottom:-30px; margin: 0 auto; overflow: hidden; position: absolute;top: 50px;right: 0;
                   bottom:0;left: 0; z-index:-2; height: 835px;"
        ></video>

        <div style="width:1300px; margin: 0 auto; position: relative; height: 835px;">
            <div style="position: absolute;top: 20%;left: 50%;width: 55%;text-align: center;">
                <h2 style="font-family: 'Copperplate Gothic Light', serif; font-variant: small-caps; text-transform:
                none;">Our Fallen
                    Angels</h2>
                <p style="font-size:25px; font-family: 'Copperplate Gothic Light', serif; display: block;
                font-variant: small-caps;  line-height: 40px; text-shadow: #000 1px 1px ">To fall from
                    heights, those who've ascended,<br/>
                    Seems dire and bleak, so far descended,<br/>
                    Our intentions meant to elevate,<br/>
                    Feel hollow and sullen, the burden great.<br/>
                    Our memories endure, these lives long past,<br/>
                    The hope our adventures were not our last.<br/>
                    With honor we remember these precious things,<br/>
                    The Fallen Angels, now rest their wings.</p>
            </div>
        </div>
    </section>


    <div
        style="text-align: center;padding: 5px;width: 100%;position: relative;margin: 0 auto;margin-top: -175px;
            background-color: rgba(0,0,0,.4);border-top: rgba(255,255,255,.1) 1px solid; padding-bottom:50px;">
        <h3>&mdash; IN MEMORIAM &mdash;</h3>
        <style>
            a.fallen-angel:hover {
                color: #fff !important;
                text-decoration: underline;
                transition: all;
                animation: .2s ease-in-out;
            }
        </style>
        <div style="display: flex; flex-direction: row; flex-wrap: wrap; width: 1200px; margin: 0 auto;">
            @foreach ($fallen as $member)
                <a href="{{ $member['forum_profile'] ?? '#' }}" class="fallen-angel" style="flex: 0 47%; display:
                    block; padding: 30px 15px; text-align: center; font-size: 18px; color: #bfb5b5; font: normal
                    16px/1.8em MuseoSans,century gothic,arial;"
                   target="_blank"
                >{{ $member['name'] }} &mdash; {{ $member['date_of_death'] }}</a>
            @endforeach
        </div>
    </div>



@endsection
