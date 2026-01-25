<div class="apply-overlay" style="display: none;"></div>
<div class="apply-form" style="display: none;">
    <button class="apply-close"><i class="fa fa-times"></i></button>

    @if ($aod_divisions)
        <div class="floating-icons" aria-hidden="true">
            @foreach (collect($aod_divisions)->shuffle()->take(8) as $index => $division)
                <img src="{{ $division['icon'] }}" alt="" class="floating-icon" style="animation-delay: {{ $index * 0.5 }}s;" />
            @endforeach
        </div>
    @endif

    <div class="apply-content">
        <h2>Register an account</h2>
        <p>You must have an account in order to apply for one of our divisions.</p>
        <a href="https://tracker.clanaod.net/auth/discord" target="_blank" class="call-to-action-button is-small">
            <i class="fab fa-discord"></i> Register with Discord
        </a>
        <p class="alt-register">or <a href="https://clanaod.net/forums" target="_blank">create a forum account</a></p>
    </div>
</div>
