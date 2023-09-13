<?php

use App\Models\AnswerResponse;
use App\Models\EveryEpoch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $epochresponses = AnswerResponse::where('context_type', EveryEpoch::class)->cursor();

        // foreach ($epochresponses as $response) {
        //     $date = Carbon::parse($response->created_at)->toDateTimeString();
        //     $epochNumber = $this->convertToEpoch($date);

        //     $everyEpoch = EveryEpoch::where('epoch', $epochNumber)->first();

        //     if ($everyEpoch instanceof EveryEpoch) {
        //         DB::table('answer_responses')
        //             ->where('id', $response->id)
        //             ->update([
        //                 'context_id' => $everyEpoch->id,
        //             ]);
        //     }
        // }
    }

    public function convertToEpoch($date)
    {
        // try {
        //     return Http::get(
        //         config('cardano.lucidEndpoint') . '/cardano/epoch',
        //         compact('date')
        //     )->throw()->body() ;
        // } catch (\Throwable $th) {
        //     return null;
        // }
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
