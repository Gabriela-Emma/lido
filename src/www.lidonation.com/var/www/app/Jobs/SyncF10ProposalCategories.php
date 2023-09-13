<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class SyncF10ProposalCategories implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Proposal::whereRelation('fund.parent', 'id', 113)->each(
            function ($proposal) {
                $data = $this->getIdeaScaleData($proposal);
                if (! $data || ! isset($data->fieldSections) || ! is_array($data->fieldSections)) {
                    Log::warning('Invalid data for proposal '.$proposal->id);

                    return;
                }
                // Remove existing relationships
                $proposal->categories()->sync([]);

                if (! $proposal->categories?->count() ?? null) {
                    $category = $this->getFieldByTitle(
                        $data->fieldSections,
                        '[METADATA] Category of proposal'
                    )->ideaFieldValues[0]['value'];

                    $existingCat = Category::where('title', $category)->first();

                    if ($existingCat instanceof Category) {
                        $proposal->categories()->syncWithoutDetaching([
                            $existingCat->id => ['model_type' => Proposal::class],
                        ]);

                        Proposal::withoutSyncingToSearch(fn () => $proposal->save());
                    } else {
                        $newCategory = Category::updateOrCreate(
                            [
                                'slug' => Str::slug($category),
                            ],
                            [
                                'title' => ucfirst($category),
                            ],
                        );

                        $proposal->categories()->syncWithoutDetaching([
                            $newCategory->id => ['model_type' => Proposal::class],
                        ]);

                        Proposal::withoutSyncingToSearch(fn () => $proposal->save());
                    }
                }
            }
        );
    }

    public function getIdeaScaleData($proposal)
    {
        $parts = collect(explode('/', $proposal->ideascale_link))->last();
        $ideascaleId = collect(explode('-', $parts))->first();

        $authResponse = Http::get('https://cardano.ideascale.com/a/community/api/get-token');
        if (! $authResponse->successful()) {
            return;
        }
        $response = Http::withToken($authResponse->body())
            ->get("https://cardano.ideascale.com/a/community/api/idea/{$ideascaleId}/detail");

        if (! $response->successful()) {
            return;
        }

        return $response->object()?->data;
    }

    protected function getFieldByTitle($fieldSections, string $title)
    {

        $targetField = array_filter(
            $fieldSections,
            fn ($obj) => strtolower($obj->title) === strtolower($title)
        );

        if (! $targetField) {
            return new Fluent([]);
        }

        $targetField = reset($targetField);
        $targetField = json_decode(json_encode($targetField), true);

        return new Fluent($targetField);
    }
}
