<?php

describe('Canonical host redirect', function () {
    it('redirects a non-canonical host to www.clanaod.net in production', function () {
        app()->instance('env', 'production');

        $response = $this->get('http://warthunder.clanaod.net/divisions');

        $response->assertRedirect('http://www.clanaod.net/divisions');
    });

    it('does not redirect the canonical www host', function () {
        app()->instance('env', 'production');

        $response = $this->get('http://www.clanaod.net/divisions');

        $response->assertOk();
    });

    it('does not redirect the bare apex host', function () {
        app()->instance('env', 'production');

        $response = $this->get('http://clanaod.net/divisions');

        $response->assertOk();
    });

    it('does not redirect outside production', function () {
        $response = $this->get('http://warthunder.clanaod.net/divisions');

        $response->assertOk();
    });
});
