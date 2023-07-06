<?php

use App\Models\EveryEpoch;
use App\Models\AnswerResponse;
use Illuminate\Support\Facades\DB;
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
        $epochresponses = AnswerResponse::cursor()->filter(function (AnswerResponse $answerResponse) {
            return $answerResponse->context_type == EveryEpoch::class;
        });
        foreach ($epochresponses as $response) {
            // $epochNumber = $this->convertToEpoch($response->created_at);

            $everyEpoch = EveryEpoch::where('epoch', 380)->first();

            if ($everyEpoch instanceof EveryEpoch) {
                DB::table('answer_responses')
                    ->where('id', $response->id)
                    ->update([
                        'context_id' => $everyEpoch->id,
                    ]);
            }
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
