<?php

declare(strict_types=1);

use App\Models\Idea;
use App\Models\User;

it('Create A New Idea', function () {

    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-btn')
        ->fill('title', 'My New Idea')
        ->click('@status-btn-completed')
        ->fill('description', 'An Testing Description')
        ->fill('@new-step', 'Do a thing')
        ->click('@add-step-btn')
        ->fill('@new-link', 'https://example.com')
        ->click('@add-link-btn')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@add-link-btn')
        ->click('Create')
        ->assertUrlIs(route('idea.index'));

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'My New Idea',
        'status' => 'completed',
        'description' => 'An Testing Description',
        'links' => ['https://example.com', 'https://laravel.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
    expect($idea->steps->first()->description)->toBe('Do a thing');

});

it('Edites An Existing Idea', function () {

    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-btn')
        ->fill('title', 'Some Example Idea')
        ->click('@status-btn-completed')
        ->fill('description', 'An Testing Description')
        ->fill('@new-step', 'Do a thing')
        ->click('@add-step-btn')
        ->fill('@new-link', 'https://example.com')
        ->click('@add-link-btn')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@add-link-btn')
        ->click('Create')
        ->assertUrlIs(route('idea.index'));

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some Example Idea',
        'status' => 'completed',
        'description' => 'An Testing Description',
        'links' => ['https://example.com', 'https://laravel.com'],
    ]);

    expect($idea->steps)->toHaveCount(2);
    expect($idea->steps->pluck('description'))->toContain('Do a thing');

});
