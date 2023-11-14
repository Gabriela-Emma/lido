<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\CatalystUser;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use MeiliSearch\Endpoints\Indexes;

class ProposalSearchController extends Controller
{
    public function bookmarks(Request $request): ?Collection
    {
        $searchGroup = $request->input('searchGroup');
        $label = $request->input('label');
        $filters = $request->input('filters');
        $term = $request->input('term');
        if ($searchGroup == 'oneTimers' || $searchGroup == 'firstTimers') {
            $searchBuilder = CatalystUser::search($term,
                function (Indexes $index, $query, $options) use ($filters) {
                    $options['filter'] = implode(' AND ', $filters);
                    $options['limit'] = 80;
                    $options['attributesToRetrieve'] = ['id', 'proposals.id'];

                    return $index->search($query, $options);
                });
        } else {
            $searchBuilder = Proposal::search($term,
                function (Indexes $index, $query, $options) use ($filters) {
                    $options['filter'] = implode(' AND ', $filters);
                    $options['attributesToRetrieve'] = ['id'];
                    $options['limit'] = 80;

                    return $index->search($query, $options);
                });
        }

        return $searchBuilder->get()?->map(fn ($p) => [
            'id' => $p->id,
            'title' => $p->title,
            'type' => $p->type,
            'amount' => $p->amount_requested,
            'ideascale_link' => $p->ideascale_link,
            'link' => $p->link,
            'fundId' => $p->fund->id,
            'fundTitle' => $p->fund->title,
            'fundAmount' => $p->fund->amount,
            'proposalsCount' => $p->fund->proposals_count,
            'fundHero' => $p->fund?->thumbnail_url,
            'labels' => [$label],
        ]
        );
    }
}
