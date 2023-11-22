<?php

namespace App\Nova;

use App\Models\Nft;
use App\Models\Post;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\CacheNftImage;
use App\Nova\Actions\EditMetaData;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Nfts extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Nft::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Store';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Name'))->translatable()->sortable()->rulesFor('en', [
                'required',
            ]),
            BelongsTo::make('Author', 'author', User::class)->searchable()->hideFromIndex(),
            BelongsTo::make('Artist', 'artist', User::class)->searchable(),
            Text::make(__('Policy'), 'policy')->hideFromIndex(),
            Text::make(__('Owner Address'))->hideFromIndex(),
            Text::make(__('Rarity'))->sortable(),
            Number::make(__('Price'))->sortable(),
            Number::make(__('Quantity'), 'qty')->default(1)->sortable(),
            Text::make(__('Currency'))->default('usd'),
            URL::make(__('Preview Link'), 'preview_link')->rules(['required']),
            URL::make(__('Storage URI'), 'storage_link')->rules(['required'])->hideFromIndex(),
            MorphTo::make(__('Model'), 'model')->types([
                Post::class,
                Reviews::class,
                Insights::class,
                Podcasts::class,
                User::class,
                LearningTopics::class,
            ])->searchable()->nullable(),
            Select::make(__('Status'), 'status')
                ->sortable()
                ->default('draft')
                ->rules(['required'])
                ->options([
                    'draft' => 'Draft',
                    'minting' => 'Minting',
                    'minted' => 'Minted',
                    'burnt' => 'Burnt',
                    'blacklisted' => 'Blacklisted',
                ]),
            DateTime::make(__('Minted At'), 'minted_at'),
            KeyValue::make('Metadata', 'metadata')->rules('json')->resolveUsing(function ($object) {
                return collect($object)?->sortKeys();
            }),
            Images::make(__('Hero'), 'hero')
                ->conversionOnDetailView('preview')
                ->conversionOnIndexView('thumbnail')
                ->enableExistingMedia(),
            Markdown::make(__('description'))->translatable(),
            HasMany::make('Promos', 'promos', Promos::class),
            HasMany::make('Transactions', 'txs', Txs::class),
            HasMany::make('Metadata', 'metas', Metas::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(NovaRequest $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                new CacheNftImage,
                (new AddMetaData),
                (new EditMetaData(\App\Models\Nft::class)),
                ExportAsCsv::make()->nameable(),

            ]);
    }
}
