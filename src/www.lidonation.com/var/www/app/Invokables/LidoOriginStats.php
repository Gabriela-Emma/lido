<?php

namespace App\Invokables;

use App\Enums\FathomEventIdsEnum;
use App\Http\Integrations\Fathom\FathomConnector;
use App\Http\Integrations\Fathom\Requests\GetCatalystQueries;
use App\Http\Integrations\Fathom\Requests\GetPageViews;
use App\Models\Insight;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Saloon\Http\Response;

class LidoOriginStats
{
    public string $theme;

    public int $newsArticles;

    public int $educationalArticles;

    public int $minutesOfAudioReadings;

    public int $hrsOfTwitterSpacesWork;

    public ?int $thirtyDaysPageViews;

    public int $thirtyDaysCatalystQueries;

    public function __invoke(): array
    {
        $this->newsArticles = Post::whereHas('categories', function($q) {
                $q->where('slug', 'news-and-interviews');
            })
            ->count();;
        $this->educationalArticles = Insight::count();
        $this->minutesOfAudioReadings = $this->getAudioMinutes();
        $this->hrsOfTwitterSpacesWork = $this->getHoursOfTwitterSpace();

        $this->get30DaysPageViews();
        $this->get30DaysCatalystQueries();

        return [
            $this->newsArticles, $this->educationalArticles,
            $this->minutesOfAudioReadings, $this->hrsOfTwitterSpacesWork,
            $this->thirtyDaysPageViews, $this->thirtyDaysCatalystQueries,
        ];
    }

    public function getAudioMinutes()
    {
        return 540;
    }

    public function getHoursOfTwitterSpace(): int
    {
        return 12;
    }

    public function get30DaysPageViews(): void
    {
        $days = 30;
        $redisKey = $days.'-days-page-view';

        $connector = new FathomConnector();
        $request = new GetPageViews($days);
        $response = $connector->send($request);

        $response->onError(function (Response $response) use ($redisKey) {
            $this->thirtyDaysPageViews = Redis::get($redisKey) ?? 12600;
        });

        try {
            $pageViews = $response->json()[0]['pageviews'];

            // delete existing pageViews cache
            Redis::get($redisKey) ? Redis::del($redisKey) : '';

            //cache pageViews for 7 days
            $expirationInSeconds = 7 * 24 * 60 * 60;
            Redis::setex($redisKey, $expirationInSeconds, $pageViews);

            $this->thirtyDaysPageViews = Redis::get($redisKey);
        } catch (Exception $e) {
            $this->thirtyDaysPageViews = Redis::get($redisKey) ?? 12600;

            Log::error($e);
        }
    }

    public function get30DaysCatalystQueries(): void
    {
        $days = 30;
        $eventIds = [
            FathomEventIdsEnum::GROUP_SEARCH,
            FathomEventIdsEnum::MONTHLY_REPORTS,
            FathomEventIdsEnum::PA,
            FathomEventIdsEnum::PROFILE,
            FathomEventIdsEnum::PROPOSAL_BOOKMARK,
            FathomEventIdsEnum::PROPOSAL,
            FathomEventIdsEnum::USER,
        ];

        $results = [];
        foreach ($eventIds as $eventId) {
            $redisKey = $days.'-event-'.$eventId;

            $connector = new FathomConnector();
            $request = new GetCatalystQueries($eventId, $days);
            $response = $connector->send($request);

            $response->onError(function () use ($redisKey) {
                $results[] = Redis::get($redisKey) ?? 3500;
            });

            if ($response->status() == 200) {
                try {
                    $queriesCount = $response->json()[0]['conversions'];

                    // delete existing pageViews cache
                    Redis::get($redisKey) ? Redis::del($redisKey) : '';

                    //cache pageViews for 7 days
                    $expirationInSeconds = 7 * 24 * 60 * 60;
                    Redis::setex($redisKey, $expirationInSeconds, $queriesCount);

                    $results[] = Redis::get($redisKey);
                } catch (Exception $e) {
                    Log::error($e);
                }
            }
        }

        $this->thirtyDaysCatalystQueries = array_sum($results) ?? 3500;
    }
}
