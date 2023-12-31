<?php

namespace App\Nova\Actions;

use App\Jobs\CrawlIohkPostsJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class fetchIohkBlog extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    protected $iohkBlogUri = 'https://iohk.io';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        CrawlIohkPostsJob::dispatchSync([$fields->link], $fields->lang);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make(__('Lang'), 'lang')->options([
                'en' => 'en',
                'ja' => 'ja',
            ]),
            Text::make(__('Link'), 'link'),
        ];
    }
}
