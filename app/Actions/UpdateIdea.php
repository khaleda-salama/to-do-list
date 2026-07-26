<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Idea;
use Illuminate\Support\Facades\DB;

class UpdateIdea
{
    public function handle(array $attributes, Idea $idea): void
    {

        $data = collect($attributes)->only([
            'title', 'description', 'status', 'links',
        ])->toArray();

        if ($attributes['image'] ?? false) {
            $data['image_path'] = $attributes['image']->store('ideas', 'public');
        }

        DB::transaction(function () use ($data, $attributes, $idea) {

            $idea->update($data);

            $steps = $attributes['steps'] ?? [];

            $sentIds = collect($steps)
                ->pluck('id')
                ->filter();

            $idea->steps()
                ->whereNotIn('id', $sentIds)
                ->delete();

            foreach ($steps as $step) {
                if (! empty($step['id'])) {

                    $idea->steps()
                        ->where('id', $step['id'])
                        ->update([
                            'description' => $step['description'],
                            'completed' => $step['completed'],
                        ]);
                } else {

                    $idea->steps()->create([
                        'description' => $step['description'],
                        'completed' => $step['completed'],
                    ]);
                }

            }

        });

    }
}
