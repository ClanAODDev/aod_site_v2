<div class="icon">
    @if (file_exists(public_path("images/division-icons/{$division['abbreviation']}.png")))
        <img class="game"
             src="{{ asset("images/division-icons/{$division['abbreviation']}.png") }}"/>
    @else
        <img class="game" src="{{ asset("images/aod_new.png") }}"/>
    @endif
</div>
