<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystTally;
use App\Models\Fund;
use App\Models\Proposal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Meilisearch\Endpoints\Indexes;
use App\Enums\CatalystExplorerQueryParams;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CatalystTalliesController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('pp', 24);
        $page = $request->input('p', 1);
        $order = $request->input('o', 'asc');
        $orderBy = $request->input('ob', 'tally');
        $search = $request->input('s', null);
        $challenges = collect($request->input('c', []));
        $funds = $request->input('fs', 113);

        $query = CatalystTally::setEagerLoads([])->with('model')
            ->where('model_type', Proposal::class)
            ->where('context_id', $funds)
            ->orderBy($orderBy, $order);

        if ($challenges->isNotEmpty()) {
            $query->whereHas(
                'model',
                fn ($q) => $q->whereIn('fund_id', $challenges->toArray())
            );
        }

        if ($search) {
            $proposalsQuery = Proposal::search(
                $search,
                function (Indexes $index, $query, $options) use ($funds) {
                    $options['filter'] = "fund.id = {$funds}";
                    $options['attributesToRetrieve'] = ['id'];

                    return $index->search($query, $options);
                }
            );

            $proposalIds = collect($proposalsQuery->raw()['hits'])->pluck('id')->toArray();
            $query->whereIn('model_id', $proposalIds);
        }

        return $query->fastPaginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Returns the total tally per fund  as a JSON response.
     *
     * @param  Request  $request The HTTP request object.
     * @return JsonResponse The JSON response containing the last updated timestamp.
     */
    public function getCatalystTallySum(Request $request): JsonResponse
    {
        $fs = $request->get(CatalystExplorerQueryParams::FUNDS);
        $query = CatalystTally::where([
            'model_type' => Proposal::class,
            'context_type' => Fund::class,
        ]);

        if ($fs !== CatalystExplorerQueryParams::ALL_FUNDS) {
            $query->where('context_id', $fs);
        }

        $catalystTally = $query->sum('tally');

        return response()->json($catalystTally);
    }

    /**
     * Returns the last updated timestamp as a JSON response.
     *
     * @param  Request  $request The HTTP request object.
     * @return JsonResponse The JSON response containing the last updated timestamp.
     */
    public function getLastUpdated(Request $request): JsonResponse
    {
        // Retrieve the most recent CatalystTally object based on the updated_at field.
        $mostRecentTally = CatalystTally::latest('updated_at')->first();

        // Create an array with the updated_at timestamp.
        $responseData = [
            'updated_at' => $mostRecentTally->updated_at?->utc(),
        ];

        // Return the JSON response.
        return response()->json($responseData);
    }

    public function getAttachementLink(Request $request)
    {
        $fs = $request->get(CatalystExplorerQueryParams::FUNDS);
        $updatedAt = Str::replace(['-', '.', ':'], '_', json_decode($this->getLastUpdated($request)->getContent())->updated_at);

        $directory = 'tallies';
        $directoryPath = storage_path('app/public/'.$directory);
        
        if ($fs !== CatalystExplorerQueryParams::ALL_FUNDS) {
            $fund = Fund::find($fs);

            $fileName = $fund->slug. '-' . $updatedAt. '.csv';
            $fullFileLink = $directoryPath.'/'.$fileName;

        } else {
            $fileName = 'all-' . $updatedAt. '.csv';
            $fullFileLink = $directoryPath.'/'.$fileName;
        }

         //create directory if it doesn't exist
         if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        if (!File::exists($fullFileLink)) {
            // The file does not exist
            $query = CatalystTally::with('proposal')
                ->where([
                    'model_type' => Proposal::class,
                    'context_type' => Fund::class,
                ]);
    
            if ($fs !== CatalystExplorerQueryParams::ALL_FUNDS) {
                $query->where('context_id', $fs);
            }

            $tallies = $query->get();

            $csvData = [];
            foreach ($tallies as $row) {
                $csvData[] = [
                    $row->proposal?->title,
                    $row->tally,
                    $row->proposal?->yes_votes_count,
                    $row->proposal?->no_votes_count,
                    $row->proposal?->amount_requested,
                    $row->hash,
                ];
            }
            
            // Add data rows
            $file = fopen($fullFileLink, 'w');
            fputcsv($file, ['title', 'votes_cast', 'yes_votes', 'no_votes', 'budget', 'onchain_id']);
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);

        }

        return Storage::url($directory . '/' . $fileName);
    }
}
