<?php

// use App\Models\Idea;
use App\Models\User;

it('Create A New Idea', function () {

    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('[data-test=create-idea-btn]')
        ->fill('title', 'My New Idea')
        ->click('@status-btn-completed')
        ->fill('description', 'An Testing Description')
        ->click('Create')
        ->assertRoute('idea.index');

    // expect(Idea::count())->toBe(1);
    expect($user->ideas()->first())->toMatchArray([
        'title' => 'My New Idea',
        'status' => 'completed',
        'description' => 'An Testing Description',
    ]);

});
