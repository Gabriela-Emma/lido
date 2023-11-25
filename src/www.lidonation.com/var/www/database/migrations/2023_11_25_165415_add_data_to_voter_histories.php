<?php

use App\Models\VoterHistory;
use App\Models\Wallet;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $filePath = '/data/catalyst-tools/voting-history/f10/';

        if ($handle = opendir($filePath)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry !== "." && $entry !== "..") {
                    if (is_file($filePath . $entry)) {
                        $fileContent = file_get_contents($filePath . $entry);

                        $dataArray = json_decode($fileContent, true);

                        if (is_array($dataArray) && empty($dataArray)) {
                            continue; 
                        }
                        $voting_stake_key = str_replace('.json', '', $entry);
                        
                        $wallet = new  Wallet ;
                        $wallet->context = 'voter_wallet';
                        $wallet->stake_address = $voting_stake_key;
                        $wallet->save();

                        collect($dataArray)->each(
                            function($item) use($wallet) {
                                $item = new Fluent($item);
                                VoterHistory::create([
                                    'wallet_id' => $wallet->id,
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
