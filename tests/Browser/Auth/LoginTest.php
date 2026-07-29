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
        ->assertRoute('idea.index');

    $this->assertAuthenticated();

});

it('Logout a user', function () {

    $user = User::factory()->create();

    $this->actingAs($user); // It`s Like Auth::login();

    visit(route('idea.index'))->click('Log Out');

    $this->assertGuest();

});
