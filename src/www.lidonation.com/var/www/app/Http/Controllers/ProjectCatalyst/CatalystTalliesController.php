<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystTally;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Meilisearch\Endpoints\Indexes;

class CatalystTalliesController extends Controller
{
    public function index(Request $request) {
        $perPage = $request->input('pp', 24);
        $page = $request->input('p', 1);
        $order = $request->input('o', 'asc');
        $orderBy = $request->input('ob', 'tally');
        $search = $request->input('s', null);
        $challenges = collect($request->input('c', []));

        $query = CatalystTally::setEagerLoads([])->with('model')
        ->where('model_type', Proposal::class)
        ->orderBy($orderBy, $order);

        if ($challenges->isNotEmpty()) {
            $query->whereHas(
                'model',
                fn($q) => $q->whereIn('fund_id', $challenges->toArray() )
            );
        }

        if ($search) {
            $proposalsQuery = Proposal::search(
                $search,
                function (Indexes $index, $query, $options) {
                    $options['filter'] = 'fund.id = 113';
                    $options['attributesToRetrieve'] = ['id'];
                    return $index->search($query, $options);
                }
            );

            $proposalIds = collect($proposalsQuery->raw()['hits'])->pluck('id')->toArray();
            $query->whereIn('model_id', $proposalIds);
        }

        return $query->fastPaginate($perPage, ['*'], 'page', $page);
    }
}
