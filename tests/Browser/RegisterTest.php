<?php

use Illuminate\Support\Facades\Auth;

it('Register a user', function () {
    visit('/register')
        ->fill('name', 'Khaled')
        ->fill('email', 'salama@ak.com')
        ->fill('password', '123456789')
        ->click('Create Account')
        ->assertPathIs('/');

    $this->assertAuthenticated();

    // $this->assertDatabaseHas('users', [
    //     'name' => 'Khaled',
    //     'email' => 'salama@ak.com',
    // ]);

    // expect(Auth::user()->name)->toBe('Khaled');

    expect(Auth::user())->toMatchArray([
        'name' => 'Khaled',
        'email' => 'salama@ak.com',
    ]);
});

it('requires a vaild email', function () {
    visit('/register')
        ->fill('name', 'Khaled')
        ->fill('email', 'salamaak.com')
        ->fill('password', '123456789')
        ->click('Create Account')
        ->assertPathIs('/');

});
