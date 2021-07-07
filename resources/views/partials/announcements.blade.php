<div class="announcements footer-section">
    <h1>Clan Announcements</h1>
    @if($aod_announcements->count())
        <ul>
            @for ($i = 0;$i < 4;$i ++)
                <li>
                    <a href="{{ $aod_announcements->item[$i]->guid }}">
                        {{ $aod_announcements->item[$i]->title }}
                    </a>
                    <br/>Posted {{ $aod_announcements->item[$i]->pubDate }}
                </li>
            @endfor
        </ul>
    @else
        <div style="width: 90%; line-height: 1.5em">
            No announcements have been posted in the past 30 days! Check out the <a
                href="https://www.clanaod.net/forums/forumdisplay.php?f=102">News and Announcements forum</a>
            for older posts.
        </div>
    @endif
</div>