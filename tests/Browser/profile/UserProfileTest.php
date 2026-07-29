<?php

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Notification;

it('requires authentication', function () {

    visit(route('profile.edit'))->assertPathIs('/login');

});

it('edits a profile', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('name', 'New Name')
        ->assertValue('email', $user->email)
        ->fill('email', 'new@example.com')
        ->click('Update Account')
        ->assertSee('Your Profile Is Updated!');

    expect($user->fresh())->toMatchArray([
        'name' => 'New Name',
        'email' => 'new@example.com',
    ]);

});

it('notifies the original email if updated', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    Notification::fake();

    $originalEmail = $user->email;

    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('email', 'new@exampe.com')
        ->click('Update Account')
        ->assertSee('Your Profile Is Updated!');

    Notification::assertSentOnDemand(EmailChanged::class, fn (EmailChanged $notification, $routes, $notifiable) => $notifiable->routes['mail'] === $originalEmail);

});
