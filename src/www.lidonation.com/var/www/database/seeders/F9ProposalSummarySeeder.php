<?php

namespace Database\Seeders;

use App\Models\CatalystUser;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class F9ProposalSummarySeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws FileCannotBeAdded|InvalidArgumentException
     */
    public function run()
    {
        $proposals = Items::fromFile(storage_path().'/json/data/f9/proposals-summary.json');

        foreach ($proposals as $p) {
            $proposal = $this->createProposal($p);
            $proposal->fund_id = match ($p->category) {
                26593 => 98,
                26594 => 99,
                26595 => 100,
                26596 => 101,
                26597 => 102,
                26598 => 103,
                26599 => 104,
                26600 => 105,
                26601 => 106,
                26602 => 107,
                26603 => 108,
                26604 => 110,
                26605 => 109,
            };
            $proposal->save();

            // save user
            $catalystUser = $this->processAuthor($p);
            $proposal?->users()->syncWithoutDetaching([$catalystUser?->id]);

            $proposal->user_id = $catalystUser->id;
            $proposal->save();
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function processAuthor(&$p): ?CatalystUser
    {
        $cu = CatalystUser::where('username', $p->author)->first();
        if (! $cu) {
            return $this->createCatalystUser($p);
        }

        return $cu;
    }

    protected function createCatalystUser($p): ?CatalystUser
    {
        return CatalystUser::updateOrCreate(
            [
                'username' => $p->author,
            ],
            [
                'username' => $p->author,
            ],
        );
    }
}
