<?php

namespace App\Http\View\Composers;

use App\Repositories\PostRepository;
use Atymic\Twitter\Facade\Twitter;
use Atymic\Twitter\Twitter as TwitterContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CommunityComposer
{
    /**
     * @var array|mixed
     */
    private mixed $tweets;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(protected PostRepository $posts)
    {
        $this->tweets = $this->getLatestTweets();
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(
            [
                'tweets' => $this->tweets,
            ]
        );
    }

    public function getLatestTweets()
    {
        $tweets = $this->getLidoTweets()?->getData()?->data;
        if (! $tweets) {
            return [];
        }

        return Cache::remember(
            'lidoTweets',
            900,
            fn () => collect($tweets)
                ->map(function ($tweet) {
                    $tweet->text = nl2br($tweet->text);
                    $tweet->created_at = Carbon::create($tweet->created_at);

                    return $tweet;
                })
        );
    }

    protected function getLidoTweets(): ?JsonResponse
    {
        $tweets = null;
        try {
            $params = [
                'place.fields' => 'country,name',
                'tweet.fields' => 'author_id,geo,created_at',
                'expansions' => 'author_id,in_reply_to_user_id',
                //                TwitterContract::KEY_RESPONSE_FORMAT => TwitterContract::RESPONSE_FORMAT_JSON,
            ];
//            $tweets = JsonResponse::fromJsonString(Twitter::userTweets(1334373952584638465, $params));
        } catch (\Exception $e) {
            report($e);
        }

        return $tweets;
    }
}
