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

    $response = $this->patch("/ideas/{$idea->id}", [
        'title' => 'My New Idea',
        'status' => 'completed',
        'description' => 'An Testing Description',
        'links' => ['https://example.com'],
        'steps' => [[
            'description' => 'Do a thing',
            'completed' => 0,
        ]],
    ], ['HTTP_REFERER' => route('idea.show', $idea)]);

    $response->assertRedirect(route('idea.show', $idea));

    $idea->refresh();

    expect($idea)->toMatchArray([
        'title' => 'My New Idea',
        'status' => 'completed',
        'description' => 'An Testing Description',
    ]);

    expect($idea->links)->toContain('https://example.com');

    expect($idea->steps)->toHaveCount(1);
});
