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
        $policy = $this->getPolicy();
        Nft::where('model_type', LearningTopic::class)->each(
            function ($nft) use ($policy) {
                $nft->policy = $policy;
                $nft->save();
            }
        );
    }


    public function getPolicy()
    {
        $seed = file_get_contents('/data/phuffycoin/wallets/mint/seed.txt');
        $res = Http::get(
            config('cardano.lucidEndpoint') . '/cardano/policy',
            compact('seed')
        )->throw();

        return  $res;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learningtopic_nfts', function (Blueprint $table) {
            //
        });
    }
};
