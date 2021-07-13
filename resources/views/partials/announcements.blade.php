<div class="announcements footer-section">
    <h1>Clan Announcements</h1>
    @if($aod_announcements)
        <ul>
            @foreach ($aod_announcements->item as $announcement)
                <li>
                    <a href="{{ $announcement->guid }}">
                        {{ $announcement->title }}
                    </a>
                    <br/>Posted {{ $announcement->pubDate }}
                </li>
                @if ($loop->iteration >= config('services.aod.max_announcements'))
                    @break
                @endif
            @endforeach
        </ul>
    @else
        <div style="width: 90%; line-height: 1.5em">
            No announcements have been posted in the past 30 days! Check out the <a
                href="https://www.clanaod.net/forums/forumdisplay.php?f=102">News and Announcements forum</a>
            for older posts.
        </div>
    @endif
</div>
