@extends ('application.base')

@section('page-title', 'Gaming Divisions')
@section('og-description', 'Our gaming divisions are the lifeblood of the Angels of Death community. A great deal of effort goes into vetting each division request to ensure the game is a good fit and the new division will have the right leadership to support its progress.')

@section('content')
    <section class="lobby">
        <div class="section-content-container">
            <div class="section--short-width">
                <div class="section-image"></div>
                <div class="section-blurb">
                    <h1>Gaming Divisions</h1>
                    <p>Our gaming divisions are the lifeblood of the Angels of Death community. A great deal of effort
                        goes into vetting each division request to ensure the game is a good fit and the new division
                        will have the right leadership to support its progress.</p>
                </div>
            </div>

            <div class="divisions-list">
                <div class="collection">
                    @forelse ($aod_divisions as $division)
                        <a href="{{ route("division.show", \Str::slug($division['name'])) }}" class="item game-button">
                            <div class="icon">
                                <img class="game"
                                     src="{{ asset("images/division-icons/{$division['abbreviation']}.png") }}"/>
                            </div>
                            <div class="meta">
                                <div class="title">{{ $division['name'] }}</div>
                                <div class="members">{{ $division['members_count'] }} Members</div>
                            </div>
                        </a>

                    @empty
                        <p>No divisions to display</p>
                    @endforelse

                </div>
            </div>
        </div>
    </section>

@endsection
