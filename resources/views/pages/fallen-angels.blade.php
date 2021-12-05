@extends ('application.base')

@section('page-title', 'Fallen Angels')
@section('og-description', 'The Clan AOD community has a storied history, and through the years some have been lost.
This is our way of honoring their memory; May their souls rest in peace.')

@section('content')

    <section id="fallen-angels">
        <video src="{{ asset('images/memoriam-v2.webm') }}"
               preload="auto" loop playsinline muted autoplay
               id="angel-of-death"
        ></video>

        <div id="epitaph-container">
            <div id="epitaph">
                <h2 id="lead">Our Fallen Angels</h2>
                <p id="body">To fall from heights, those who've ascended,<br/>
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

    <div id="members-container">
        <h3>&mdash; IN MEMORIAM &mdash;</h3>
        <div id="member-list">
            @foreach ($fallen as $member)
                <a href="{{ $member['forum_profile'] ?? '#' }}" class="fallen-angel"
                   target="_blank"
                >{{ $member['name'] }} &mdash; {{ $member['date_of_death'] }}</a>
            @endforeach
        </div>
    </div>



@endsection
