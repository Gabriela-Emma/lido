<?php

use App\Models\Wallet;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\CatalystExplorer\VoterHistory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            $filePath = '/data/catalyst-tools/voting-history/f10/';

            if (file_exists($filePath) && $handle = opendir($filePath)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry !== "." && $entry !== "..") {
                        if (is_file($filePath . $entry)) {
                            $fileContent = file_get_contents($filePath . $entry);

                            $dataArray = json_decode($fileContent, true);

                            if (is_array($dataArray) && empty($dataArray)) {
                                continue;
                            }

                            $voting_stake_key = str_replace('.json', '', $entry);

                            collect($dataArray)->each(
                                function ($item) use ($voting_stake_key) {
                                    $item = new Fluent($item);
                                    VoterHistory::create([
                                        'stake_address' => $voting_stake_key,
                                        'fragment_id' => $item->fragment_id,
                                        'caster' => $item->caster,
                                        'time' => $item->time,
                                        'raw_fragment' => $item->raw_fragment,
                                        'proposal' => $item->proposal,
                                        'choice' => $item->choice
                                    ]);
                                }
                            );
                        }
                    }
                }
                closedir($handle);
            }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
