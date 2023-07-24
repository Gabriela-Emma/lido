<?php

use App\Models\Nft;
use App\Models\LearningTopic;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            $policy = $this->getPolicy();

            Nft::where('model_type', LearningTopic::class)->each(function ($nft) use ($policy) {
                $nft->policy = $policy;
                $nft->save();
            });
        } catch (Exception $e) {
            echo "Error occurred: " . $e->getMessage();
        }
    }

    public function getPolicy()
    {
        $seedFile = '/data/phuffycoin/wallets/mint/seed.txt';

        if (!file_exists($seedFile)) {
            throw new Exception("Seed file not found: $seedFile");
        }

        $seed = file_get_contents($seedFile);

        if (empty($seed)) {
            throw new Exception("Seed file is empty: $seedFile");
        }

        $res = Http::get(config('cardano.lucidEndpoint') . '/cardano/policy', compact('seed'))->throw();

        return $res;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Implement down migration logic if necessary.
    }
};
