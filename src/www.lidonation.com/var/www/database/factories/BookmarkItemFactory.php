<?php

namespace Database\Factories;

use App\Models\BookmarkItem;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookmarkItem>
 */
class BookmarkItemFactory extends Factory
{
    protected $model = BookmarkItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $proposal = Proposal::inRandomOrder()->first();

        return [
            'model_id' => $proposal->id,
            'model_type' => $proposal::class,
        ];
    }
}
