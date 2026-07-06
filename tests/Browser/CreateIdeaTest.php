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
        ->fill('@new-link', 'https://example.com')
        ->click('@add-link-btn')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@add-link-btn')
        ->click('Create')
        ->assertRoute('idea.index');

    // expect(Idea::count())->toBe(1);
    expect($user->ideas()->first())->toMatchArray([
        'title' => 'My New Idea',
        'status' => 'completed',
        'description' => 'An Testing Description',
        'links' => ['https://example.com', 'https://laravel.com'],
    ]);

});
