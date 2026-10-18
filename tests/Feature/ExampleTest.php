<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the landing page returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('rel="icon"', false);
    $response->assertSee('image/sewain_logo.png', false);
});

test('the login page shows the Sewain logo and favicon', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('rel="icon"', false);
    $response->assertSee('image/sewain_logo.png', false);
});
