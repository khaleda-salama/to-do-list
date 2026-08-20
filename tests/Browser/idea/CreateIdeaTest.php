<?php

declare(strict_types=1);

use App\Models\User;

it('Create A New Idea', function () {

    $this->actingAs($user = User::factory()->create());

    $response = $this->post('/ideas', [
        'title' => 'My New Idea',
        'status' => 'completed',
        'description' => 'An Testing Description',
        'links' => ['https://example.com'],
        'steps' => [[
            'description' => 'Do a thing',
            'completed' => 0,
        ]],
    ]);

    $response->assertRedirect('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'My New Idea',
        'status' => 'completed',
        'description' => 'An Testing Description',
        'links' => ['https://example.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});
