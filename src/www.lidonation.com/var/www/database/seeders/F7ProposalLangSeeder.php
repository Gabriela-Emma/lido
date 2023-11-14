<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Fluent;
use JsonMachine\Items;

class F7ProposalLangSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // save proposals
        foreach (Proposal::cursor() as $proposal) {
            $fundId = $proposal->fund->meta_data->ideascale_id;
            $proposalId = $proposal->meta_data->ideascale_id;
            if (! $fundId || ! $proposal) {
                continue;
            }

            $pEs = null;
            $path = storage_path()."/json/data/f7/es/$fundId/proposals/{$proposalId}.json";
            if (file_exists($path)) {
                $pEs = new Fluent(
                    Items::fromFile($path)
                );
            }

            $pFr = null;
            $path = storage_path()."/json/data/f7/fr/$fundId/proposals/{$proposalId}.json";
            if (file_exists($path)) {
                $pFr = new Fluent(
                    Items::fromFile($path)
                );
            }

            $pJa = null;
            $path = storage_path()."/json/data/f7/ja/$fundId/proposals/{$proposalId}.json";
            if (file_exists($path)) {
                $pJa = new Fluent(
                    Items::fromFile($path)
                );
            }

            $pPt = null;
            $path = storage_path()."/json/data/f7/pt/$fundId/proposals/{$proposalId}.json";
            if (file_exists($path)) {
                $pPt = new Fluent(
                    Items::fromFile($path)
                );
            }

            $pRu = null;
            $path = storage_path()."/json/data/f7/ru/$fundId/proposals/{$proposalId}.json";
            if (file_exists($path)) {
                $pRu = new Fluent(
                    Items::fromFile($path)
                );
            }

            $pZh = null;
            $path = storage_path()."/json/data/f7/zh/$fundId/proposals/{$proposalId}.json";
            if (file_exists($path)) {
                $pZh = new Fluent(
                    Items::fromFile($path)
                );
            }

            $pEn = null;
            $path = storage_path()."/json/data/f7/$fundId/proposals/{$proposalId}.json";
            if (file_exists($path)) {
                $pEn = new Fluent(
                    Items::fromFile(storage_path()."/json/data/f7/$fundId/proposals/{$proposalId}.json")
                );
            }

            $proposal->title = [
                'en' => $pEn?->title ?? $proposal?->title,
                'es' => $pEs?->title,
                'fr' => $pFr?->title,
                'ja' => $pJa?->title,
                'pt' => $pPt?->title,
                'ru' => $pRu?->title,
                'zh' => $pZh?->title,
            ];

            $proposal->problem = [
                'en' => $pEn?->description ?? $proposal?->description,
                'es' => $pEs?->description,
                'fr' => $pFr?->description,
                'ja' => $pJa?->description,
                'pt' => $pPt?->description,
                'ru' => $pRu?->description,
                'zh' => $pZh?->description,
            ];

            $proposal->solution = [
                'en' => $pEn?->solution ?? $proposal?->solution,
                'es' => $pEs?->solution,
                'fr' => $pFr?->solution,
                'ja' => $pJa?->solution,
                'pt' => $pPt?->solution,
                'ru' => $pRu?->solution,
                'zh' => $pZh?->solution,
            ];

            $proposal->experience = [
                'en' => $pEn?->experience ?? $proposal?->experience,
                'es' => $pEs?->experience,
                'fr' => $pFr?->experience,
                'ja' => $pJa?->experience,
                'pt' => $pPt?->experience,
                'ru' => $pRu?->experience,
                'zh' => $pZh?->experience,
            ];

            $proposal->save();
        }
    }
}
