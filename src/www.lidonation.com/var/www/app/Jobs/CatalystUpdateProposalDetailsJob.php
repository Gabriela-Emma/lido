<?php

namespace App\Jobs;

use App\Models\CatalystExplorer\CatalystUser;
use App\Models\CatalystExplorer\Proposal;
use App\Models\Category;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use League\HTMLToMarkdown\HtmlConverter;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class CatalystUpdateProposalDetailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Proposal|int $proposal, public $includeBasicDetails = false)
    {
    }

    /**
     * Execute the job.
     *
     *
     * @throws FileCannotBeAdded
     */
    public function handle(): void
    {
        if (!$this->proposal instanceof Proposal) {
            $this->proposal = Proposal::find($this->proposal);
        }
        $parts = collect(explode('/', $this->proposal->ideascale_link))->last();
        $ideascaleId = collect(explode('-', $parts))->first();

        $authResponse = Http::get('https://cardano.ideascale.com/a/community/api/get-token');
        if (!$authResponse->successful()) {
            return;
        }
        $response = Http::withToken($authResponse->body())
            ->get("https://cardano.ideascale.com/a/community/api/idea/{$ideascaleId}/detail");

        if (!$response->successful()) {
            return;
        }

        $data = $response->object()?->data;

        $author = $this->processPrimaryAuthor($data);

        $converter = new HtmlConverter();

        // basic details
        [$solution, $experience] = [null, null];
        if ($this->proposal->fund?->parent_id == 113) {
            $this->proposal->problem = $converter->convert(
                Str::replace('/a/attachments/', 'https://cardano.ideascale.com/a/attachments/', $data->description)
            );

            $solution = collect($data->fieldSections)
                ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldName === 'CF_213')
                ->first()?->ideaFieldValues[0]?->value ?? null;
            $this->proposal->solution = $converter->convert(
                Str::replace('/a/attachments/', 'https://cardano.ideascale.com/a/attachments/', $solution)
            );
        } else {
            if ($this->proposal->fund?->parent?->id == 58) {
                [$solution, $experience] = $this->getFund7BasicDetails($data->fieldSections);
            }
            if ($this->proposal->fund?->parent_id == 129) {
                $this->proposal->problem = $converter->convert(
                    Str::replace('/a/attachments/', 'https://cardano.ideascale.com/a/attachments/', $data->description)
                );

                $solution = collect($data->fieldSections)
                    ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldName === 'CF_286')
                    ->first()?->ideaFieldValues[0]?->value ?? null;
                $this->proposal->solution = $converter->convert(
                    Str::replace('/a/attachments/', 'https://cardano.ideascale.com/a/attachments/', $solution)
                );
            }
            if ($data?->description && !$this->proposal?->problem) {
                $this->proposal->problem = $converter->convert(
                    Str::replace('/a/attachments/', 'https://cardano.ideascale.com/a/attachments/', $data->description)
                );
            }
            if ($solution && !$this->proposal?->solution) {
                $this->proposal->solution = $solution;
            }
            if ($experience && !$this->proposal?->experience) {
                $this->proposal->experience = $experience;
            }
        }

        // sync co-proposers
        dump($this->proposal->id);
        $coSubmitters = $this->processCoProposers($data);
        $this->proposal?->users()->sync($coSubmitters->filter()->values()->push($author->id));


        // save detailed content
        $content = null;
        if ($this->proposal->fund?->parent_id == 21) {
            $fieldSections = $this->getFund7ProposalDetails($data->fieldSections);
            $content = (string) $fieldSections->implode('');
        }
        if ($this->proposal->fund?->parent_id == 58) {
            $fieldSections = $this->getFund7ProposalDetails($data->fieldSections);
            $content = (string) $fieldSections->implode('');
        }
        if ($this->proposal->fund?->parent_id == 97) {
            $fieldSections = $this->getFund9ProposalDetails($data->fieldSections);

            $content = (string) $fieldSections->implode('');
        }
        if ($this->proposal->fund?->parent_id == 113 || $this->proposal->fund?->parent_id == 129) {
            $fieldSections = $this->getFund10ProposalDetails($data->fieldSections);
            $content = (string) $fieldSections->implode('');

            // save requested amount
            if ($this->proposal->fund?->parent_id == 113) {
                $proposalMeta = $this->getFund10ProposalMetas($data->fieldSections);
            } elseif ($this->proposal->fund?->parent_id == 129) {
                $proposalMeta = $this->getFund11ProposalMetas($data->fieldSections);
            }

            $this->proposal->amount_requested = $proposalMeta?->amount_requested;

            // opensource status
            $isOpensource = $this->getFieldByTitle(
                $data->fieldSections,
                '[GENERAL] Will your project’s output/s be fully open source?'
            );

            if (isset($isOpensource) && isset($isOpensource->ideaFieldValues[0]) && isset($isOpensource->ideaFieldValues[0]['value'])) {
                $this->proposal->opensource = $isOpensource->ideaFieldValues[0]['value'] == 'Yes' ? true : false;
            }

            $this->proposal->saveMeta('project_length', $proposalMeta?->project_length, $this->proposal);
        }


        if ($this->proposal->fund?->parent_id == 61) {
            $fieldSections = $this->getFund8ProposalDetails($data->fieldSections);
            $content = (string) $fieldSections->implode('');
        }

        $this->proposal->content = Str::replace('/a/attachments/', 'https://cardano.ideascale.com/a/attachments/', $content);

        $this->proposal->user_id = $author?->id;

        // Save and Sync links
        $links = $this->getFund98ProposalLinks($data->fieldSections);
        $links = $links->map(function ($link, $index) {
            return Link::withoutSyncingToSearch(fn () => Link::updateOrCreate(
                [
                    'link' => $link,
                ],
                [
                    'link' => $link,
                    'status' => 'published',
                    'label' => 'link',
                    'title' => 'Relevant Link ' . $index + 1,
                    'valid' => true,
                ],
            ));
        });
        $this->proposal?->links()->syncWithPivotValues($links->pluck('id'), [
            'model_type' => Proposal::class,
        ], false);

        // save proposal without trigger search index
        if ($this->proposal->fund?->parent_id == 113) {
            $this->proposal->save();
        } else {
            Proposal::withoutSyncingToSearch(fn () => $this->proposal->save());
        }

        // save videos
        $videos = $this->getFund98ProposalVideos($data->fieldSections);
        if ($videos->isNotEmpty()) {
            $videos->each(function ($video) {
                if (Str::contains($video, ['youtube', 'yt.'])) {
                    $this->proposal->saveMeta('youtube', $video, $this->proposal);
                } elseif (Str::contains($video, ['vimeo'])) {
                    $this->proposal->saveMeta('vimeo', $video, $this->proposal);
                } else {
                    $this->proposal->saveMeta('video', $video, $this->proposal);
                }
            });
        }

        // save attachments
        if (!$this->proposal->hasMedia('hero')) {
            $attachments = collect($data?->attachments);
            if ($attachments->isNotEmpty()) {
                $attachments->each(function ($att) {
                    $this->proposal->addMediaFromUrl($att?->url)
                        ->toMediaCollection('hero');
                });
            }
        }

        // Save Tags
        if (!($this->proposal->tags?->count() ?? null)) {
            $category = $this->getFieldByTitle(
                $data->fieldSections,
                '[METADATA] Themes:'
            )->ideaFieldValues[0]['value'];

            $tags = collect(explode(", ", $category));

            $tags = $tags->map(function ($tag, $index) {
                return Tag::updateOrCreate(
                    [
                        'slug' => Str::slug($tag),
                    ],
                    [
                        'title' => ucfirst($tag),
                    ],
                );
            });
            $this->proposal?->tags()->syncWithPivotValues($tags->pluck('id'), [
                'model_type' => Proposal::class,
            ], false);
        }

        //save proposal category
        // clean previous categories
        // $existingCategoryIDs = $this->proposal->categories()->pluck('id');
        // $this->proposal->categories()->detach($existingCategoryIDs);
        // // Delete the categories
        // foreach ($existingCategoryIDs as $categoryId) {
        //     $category = Category::find($categoryId);
        //     $category->delete();
        // }

        // if (! $this->proposal->categories?->count() ?? null) {
        //     // $category = $this->getFieldByTitle(
        //     //     $data->fieldSections,
        //     //     '[METADATA] Category of proposal'
        //     // )->ideaFieldValues[0]['value'];

        //     $category = $this->getFieldByTitle(
        //         $data->fieldSections,
        //         '[METADATA] Themes:'
        //     )->ideaFieldValues[0]['value'];

        //     $items = explode(", ", $category);

        //     foreach ($items as $item) {
        //         $existingCat = Category::where('title', $item)->first();
        //     }

        //     if ($existingCat instanceof Category) {

        //         $this->proposal?->categories()->syncWithPivotValues($existingCat->pluck('id'), [
        //             'model_type' => Proposal::class,
        //         ], false);

        //         Proposal::withoutSyncingToSearch(fn () => $this->proposal->save());
        //     } else {

        //         $category = Category::updateOrCreate(
        //             [
        //                 'slug' => Str::slug($category),
        //             ],
        //             [
        //                 'title' => ucfirst($category),
        //             ],
        //         );
        //         $this->proposal?->categories()->syncWithPivotValues($category->pluck('id'), [
        //             'model_type' => Proposal::class,
        //         ], false);

        //         Proposal::withoutSyncingToSearch(fn () => $this->proposal->save());
        //     }

        // }
    }

    protected function processCoProposers(&$data): Collection
    {
        return collect($data->coSubmitters)->map(function ($user) {
            if (!$user->username) {
                return false;
            }
            $cu = CatalystUser::where('username', $user->username)
                ->orWhere('ideascale_id', $user->id)
                ->first();

            if (!$cu instanceof CatalystUser) {
                $cu = new CatalystUser;
            }
            $cu->name = $user?->name;
            $cu->username = $user?->username;
            $cu->ideascale_id = $user?->id;
            $cu->save();


            try {
                if (!$cu->hero) {
                    $cu->addMediaFromUrl($user?->avatar)
                        ->toMediaCollection('hero');
                }
            } catch (UnreachableUrl $exception) {
                report($exception);
            }

            CatalystUser::withoutSyncingToSearch(fn () => $cu->save());

            return $cu->id;
        });
    }

    protected function getFund7BasicDetails(&$data): array
    {
        $solution = $data[0]?->ideaFieldValues[0]?->value;
        $experience = $data[1]?->ideaFieldValues[0]?->value;

        return [$solution, $experience];
    }

    protected function processPrimaryAuthor(&$data)
    {
        $author = CatalystUser::where('username', $data->submitter?->username)->first();
        if (!$author instanceof CatalystUser) {
            $author = new CatalystUser;
            $author->username = $data->submitter?->username;
        }
        $author->name = $data->submitter?->name;
        $author->ideascale_id = $data->submitter?->id;
        if (!$author->hero) {
            $author->addMediaFromUrl($data->submitter?->avatar)
                ->toMediaCollection('hero');
        }
        CatalystUser::withoutSyncingToSearch(fn () => $author->save());

        return $author;
    }

    protected function getFund98ProposalVideos($sections): Collection
    {
        $ytMedia = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldDisplayType === 'YOUTUBE');

        return $ytMedia->map(fn ($section) => collect($section->ideaFieldValues)->pluck('value'))
            ->collapse()
            ->filter();
    }

    protected function getFund98ProposalLinks($sections): Collection
    {
        $linkSection = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldDisplayType === 'HYPERLINK');

        return $linkSection->map(fn ($section) => collect($section->ideaFieldValues)->pluck('value'))->collapse()->filter();
    }

    protected function getFund9ProposalDetails($sections): Collection
    {
        $fieldSections = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldDisplayType === 'TEXTAREA');
        if ($this->proposal->type == 'proposal') {
            $fieldSections = $fieldSections->filter(fn ($field) => Str::contains($field?->title, ['[IMPACT]', '[FEASIBILITY]', '[AUDITABILITY]', '(SDG) Rating'], true));
        }

        return $fieldSections->map(function ($field) {
            $ideaFieldValues = collect($field->ideaFieldValues)->pluck('value')->implode('<br /><br />>');
            $converter = new HtmlConverter();

            return $converter->convert('<h3 class="mt-6">' . $field?->title . '</h3>' . $ideaFieldValues . '<br /><br /><p></p>');
        });

        //        return $fieldSections->map(function ($field) {
        //            $converter = new HtmlConverter();
        //
        //            return $converter->convert('<h3>'.$field->ideaFieldValues[0]?->title.'</h3>'.$field->ideaFieldValues[0]?->value.'<br /><br />');
        //        });
    }

    protected function getFund10ProposalDetails($sections)
    {
        $fieldSections = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldDisplayType === 'TEXTAREA');

        if ($this->proposal->type == 'proposal') {
            $fieldSections = $fieldSections->filter(fn ($field) => Str::contains($field?->title, ['[IMPACT]', '[CAPABILITY/ FEASIBILITY]', '[RESOURCES & VALUE FOR MONEY]', '[FEASIBILITY]', '[AUDITABILITY]', '(SDG) Rating'], true));
        }

        return $fieldSections->map(function ($field) {
            $ideaFieldValues = collect($field->ideaFieldValues)->pluck('value')->implode('<br /><br />>');
            $converter = new HtmlConverter();

            return $converter->convert('<h3 class="mt-6">' . $field?->title . '</h3>' . $ideaFieldValues . '<br /><br /><p></p>');
        });
    }

    protected function getFund10ProposalMetas($sections): Fluent
    {
        $requestedAmount = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldName === 'CF_210');

        $length = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldName === 'CF_211');

        return new Fluent([
            'amount_requested' => intval($requestedAmount->first()?->ideaFieldValues[0]?->value ?? 0),
            'project_length' => intval($length->first()?->ideaFieldValues[0]?->value ?? 0),
        ]);
    }

    protected function getFund11ProposalMetas($sections): Fluent
    {
        $requestedAmount = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldName === 'CF_273');

        $length = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldName === 'CF_274');

        return new Fluent([
            'amount_requested' => intval($requestedAmount->first()?->ideaFieldValues[0]?->value ?? 0),
            'project_length' => intval($length->first()?->ideaFieldValues[0]?->value ?? 0),
        ]);
    }

    protected function getFund7ProposalDetails($sections): Collection
    {
        $fieldSections = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldDisplayType === 'TEXTAREA');

        if ($this->proposal->type == 'proposal') {
            $fieldSections = $fieldSections->filter(fn ($field) => Str::contains($field?->ideaFieldValues[0]?->name, 'Detailed plan'))->values();

            return $fieldSections->map(function ($field) {
                $ideaFieldValues = collect($field->ideaFieldValues)->pluck('value')->implode('<br /><br />');
                $converter = new HtmlConverter();

                return $converter->convert('<h3>Detailed Plan</h3>' . $ideaFieldValues . '<br /><br />');
            });
        }

        return $fieldSections->map(function ($field) {
            $converter = new HtmlConverter();

            return $converter->convert('<h3>' . $field->ideaFieldValues[0]?->name . '</h3>' . $field->ideaFieldValues[0]?->value . '<br /><br />');
        });
    }

    protected function getFund8ProposalDetails($sections): Collection
    {
        $fieldSections = collect($sections)
            ->filter(fn ($field) => isset($field->ideaFieldValues[0]) && $field->ideaFieldValues[0]?->fieldDisplayType === 'TEXTAREA');

        if ($this->proposal->type == 'proposal') {
            $fieldSections = $fieldSections->filter(fn ($field) => property_exists($field, 'title'));

            return $fieldSections->map(function ($field) {
                $ideaFieldValues = collect($field->ideaFieldValues)->pluck('value')->implode('<br /><br />');
                $converter = new HtmlConverter();

                return $converter->convert('<h3>' . $field->title . '</h3>' . $ideaFieldValues . '<br /><br />');
            });
        }

        return $fieldSections->map(function ($field) {
            $converter = new HtmlConverter();

            return $converter->convert('<h3>' . $field->ideaFieldValues[0]?->name . '</h3>' . $field->ideaFieldValues[0]?->value . '<br /><br />');
        });
    }

    protected function getFundProposalTags($leaf): Collection
    {
        if ($leaf->tags) {
            return collect($leaf->tags);
        }

        return collect([]);
    }

    protected function getFieldByTitle($fieldSections, string $title)
    {

        $targetField = array_filter(
            $fieldSections,
            fn ($obj) => strtolower($obj->title) === strtolower($title)
        );

        if (!$targetField) {
            return new Fluent([]);
        }

        $targetField = reset($targetField);
        $targetField = json_decode(json_encode($targetField), true);

        return new Fluent($targetField);
    }
}
