<div class="footer-section full-width twitter-feed">
    <h1>Twitter Activity</h1>
    @if (isset($aod_tweets) && is_array($aod_tweets))
        <ul>
            @foreach ($aod_tweets as $tweet)
                <li>
                    <a href="https://twitter.com/officialclanaod" target="_blank">@officialclanaod</a>
                    {!! urlify($tweet->text) !!}
                </li>
            @endforeach
        </ul>
    @else
        <p>Could not load Twitter feed!</p>
    @endif
</div>
