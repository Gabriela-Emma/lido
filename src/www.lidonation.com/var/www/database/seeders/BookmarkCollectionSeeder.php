<?php

namespace Database\Seeders;

use App\Models\BookmarkCollection;
use App\Models\BookmarkItem;
use Illuminate\Database\Seeder;

class BookmarkCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookmarkCollection::factory(4)
            ->has(BookmarkItem::factory(4)
                ->state(function (array $attributes, BookmarkCollection $col) {
                    return [
                        'bookmark_collection_id' => $col->rawId,
                    ];
                }),
                'items')
            ->create();
    }
}
