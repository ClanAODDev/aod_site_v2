@env('local')
    <p>
        <code style="position:fixed; top:15px; left: 15px; z-index:999; color: lime;"              >
            {{ app()->environment() }} env
        </code>
    </p>
@endenv
