<?php

use App\Models\EveryEpoch;
use App\Models\AnswerResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
        $epochresponses = AnswerResponse::where('context_type', EveryEpoch::class)->cursor();

        foreach ($epochresponses as $response) {
            $epochNumber = $this->convertToEpoch($response->created_at);
            $everyEpoch = EveryEpoch::where('epoch', $epochNumber)->first();

            if ($everyEpoch instanceof EveryEpoch) {
                DB::table('answer_responses')
                    ->where('id', $response->id)
                    ->update([
                        'context_id' => $everyEpoch->id,
                    ]);
            }
        }
    }


    public function convertToEpoch($created_at)
    {
        $date = $created_at;
        try {
            return Http::get(
                config('cardano.lucidEndpoint') . '/cardano/epoch',
                compact('date')
            )->throw();
        } catch (\Throwable $th) {
            return null;
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
