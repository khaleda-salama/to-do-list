<?php

use App\Models\User;

it('Login a user', function () {

    $user = User::factory()->create([
        // 'email' => 'salama@ak.com',
        'password' => '123456789',
    ]);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', '123456789')
        ->click('@login-btn-nav')
        // ->click('[data-test=login-btn-nav]')
        ->assertPathIs('/');

    $this->assertAuthenticated();

});

it('Logout a user', function () {

    $user = User::factory()->create();

    $this->actingAs($user); // It`s Like Auth::login();

    visit('/')->click('Logout');

    $this->assertGuest();

});
