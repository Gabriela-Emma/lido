<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\LTERegisteredUsers;
use App\Nova\Metrics\QuizzesTakenCount;
use App\Nova\Metrics\ResponsesCorrectness;
use App\Nova\Metrics\TotalAdaDistributed;
use App\Nova\Metrics\TotalAdaEarned;
use App\Nova\Metrics\WalletsStakedPercentage;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    #[Pure]
    public function cards()
    {
        return [
            // new Help,
            (new WalletsStakedPercentage)->help('Relationship of users with delegated wallets aganist undelegated wallets'),
            (new LTERegisteredUsers)->help('Total number of learners registered as Learn to Earn Users.'),
            (new QuizzesTakenCount)->help('Total number of quizzes attemped.'),
            (new ResponsesCorrectness)->help('Correct and incorrect responses proportions'),
            (new TotalAdaEarned)->help("Learn to earn total Ada Earned."),
            (new TotalAdaDistributed)->help("Learn to earn total Ada distributed.")
        ];
    }
}
