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

    it('keeps https when redirecting a request forwarded by the proxy', function () {
        app()->instance('env', 'production');

        $response = $this->withHeaders(['X-Forwarded-Proto' => 'https'])
            ->get('http://warthunder.clanaod.net/divisions');

        $response->assertRedirect('https://www.clanaod.net/divisions');
    });

    it('generates https urls for requests forwarded over https', function () {
        $response = $this->withHeaders(['X-Forwarded-Proto' => 'https'])
            ->get('http://www.clanaod.net/sitemap.xml');

        $response->assertSee('<loc>https://www.clanaod.net/history</loc>', escape: false);
    });

    it('does not redirect outside production', function () {
        $response = $this->get('http://warthunder.clanaod.net/divisions');

        $response->assertOk();
    });
});
