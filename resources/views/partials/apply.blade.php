<div class="apply-form" style="display: none;">
    <h2>1. Create a forum account</h2>
    <p>You must have a forum account in order to apply for one of our divisions.</p>
    <a href="/forums/register.php" target="_blank"
       class="call-to-action-button is-small">Create an account</a>
    <hr class="margin-top-20"/>
    <h2 class="margin-top-20">2. Apply to a division</h2>
    <div class="games-listing">
        @forelse ($aod_divisions as $division)
            <a href="#" data-application-id="{{ $division['forum_app_id'] }}"
               data-application-link class="tooltips">
                <img class="game" src="{{ asset("images/division-icons/{$division['abbreviation']}.png") }}"/>
                <span>{{ $division['name'] }}</span>
            </a>
        @empty
            <p class="text-muted">No divisions available</p>
        @endforelse
    </div>
</div>
