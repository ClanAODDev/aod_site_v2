<div class="footer-section full-width twitter-feed">
    <h2>Twitter Activity</h2>
    @if (isset($aod_tweets) && is_array($aod_tweets))
        <ul>
            @foreach ($aod_tweets as $tweet)
                <li>
                    <a href="https://twitter.com/officialclanaod" target="_blank" rel="noopener noreferrer">@officialclanaod</a>
                    {!! urlify($tweet->text) !!}
                </li>
            @endforeach
        </ul>
    @else
        <p>Could not load Twitter feed!</p>
    @endif
</div>
