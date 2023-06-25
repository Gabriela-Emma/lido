<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\LTERegisteredUsers;
use App\Nova\Metrics\LTERegisteredUsersPerDay;
use App\Nova\Metrics\QuizAttemptsPerDay;
use App\Nova\Metrics\QuizzesTakenCount;
use App\Nova\Metrics\ResponsesCorrectness;
use App\Nova\Metrics\TotalAdaDistributed;
use App\Nova\Metrics\TotalAdaDistributedPerDay;
use App\Nova\Metrics\TotalAdaEarned;
use App\Nova\Metrics\TotalAdaEarnedPerDay;
use App\Nova\Metrics\WalletsStakedPercentage;
use Laravel\Nova\Dashboards\Main as Dashboard;

class SLTEInsights extends Dashboard
{
    /**
     * Get the displayable name of the dashboard.
     */
    public function name(): string
    {
        return 'SLTE Insights';
    }

    /**
     * Get the URI key of the dashboard.
     */
    public function uriKey(): string
    {
        return 'slte-insights';
    }

    /**
     * Get the cards for the dashboard.
     */
    public function cards(): array
    {
        return [
            // new Help,

            (new QuizzesTakenCount)->help('Total number of quizzes attempted.'),
            (new QuizAttemptsPerDay)->help('Total number of quizzes attempted per day.')->width('2/3'),

            (new LTERegisteredUsers)->help('Total number of learners registered as Learn to Earn Users.'),
            (new LTERegisteredUsersPerDay)->width('2/3'),

            (new WalletsStakedPercentage)->width('1/2')->help('Relationship of users with delegated wallets against undelegated wallets'),
            (new ResponsesCorrectness)->width('1/2')->help('Correct and incorrect responses proportions'),

            (new TotalAdaEarned)->help('Learn to earn total Ada Earned.'),
            (new TotalAdaEarnedPerDay)->width('2/3'),

            (new TotalAdaDistributed)->help('Learn to earn total Ada distributed.'),
            (new TotalAdaDistributedPerDay)->width('2/3'),
        ];
    }
}
