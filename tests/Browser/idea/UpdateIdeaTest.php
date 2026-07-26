<?php

declare(strict_types=1);

use App\Models\Idea;
use App\Models\User;

it('shows the initial input state', function () {

    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-btn')
        ->assertValue('title', $idea->title)
        ->assertValue('description', $idea->description)
        ->assertValue('status', $idea->status->value);

});

it('Edites An Existing Idea', function () {

    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-btn')
        ->fill('title', 'Some Example Idea')
        ->click('@status-btn-completed')
        ->fill('description', 'An Testing Description')
        ->fill('@new-link', 'https://example.com')
        ->click('@add-link-btn')
        ->fill('@new-step', 'Do a thing')
        ->click('@add-step-btn')
        ->click('@update-btn')
        ->assertRoute('idea.show', [$idea]);

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some Example Idea',
        'status' => 'completed',
        'description' => 'An Testing Description',
        'links' => [$idea->links[0], 'https://example.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});
