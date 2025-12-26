<div class="apply-overlay" style="display: none;"></div>
<div class="apply-form" style="display: none;">
    <button class="apply-close"><i class="fa fa-times"></i></button>

    <div class="apply-step">
        <span class="step-number">1</span>
        <div class="step-content">
            <h2>Create a forum account</h2>
            <p>You must have a forum account in order to apply for one of our divisions.</p>
            <a href="/forums/register.php" target="_blank" class="call-to-action-button is-small">
                <i class="fa fa-user-plus"></i> Create an account
            </a>
        </div>
    </div>

    <div class="apply-divider"></div>

    <div class="apply-step">
        <span class="step-number">2</span>
        <div class="step-content">
            <h2>Apply to a division</h2>
            <p>Select the game you want to play with us.</p>
        </div>
    </div>

    <div class="games-listing">
        @if ($aod_divisions)
            @foreach ($aod_divisions as $division)
                <a href="#" data-application-id="{{ $division['forum_app_id'] }}" data-application-link class="division-select" title="{{ $division['name'] }}">
                    <img src="{{ $division['icon'] }}" alt="{{ $division['name'] }}"/>
                    <span class="division-label">{{ $division['name'] }}</span>
                </a>
            @endforeach
        @else
            <p class="text-muted">No divisions available</p>
        @endif
    </div>
</div>
