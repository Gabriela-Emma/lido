<?php

namespace Database\Seeders;

use App\Models\AnswerResponse;
use Illuminate\Database\Seeder;

class AnswerResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnswerResponse::factory(10)->create();
    }
}
