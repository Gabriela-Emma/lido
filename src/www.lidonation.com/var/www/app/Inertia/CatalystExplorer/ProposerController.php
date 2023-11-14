<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\CatalystUser;

class ProposerController extends Controller
{
    public function getCompletedProposalCount(CatalystUser $catalystUser)
    {
        return $catalystUser->proposals()->where('status', 'complete')->count();
    }

    public function getOutstandingProposalCount(CatalystUser $catalystUser)
    {
        return $catalystUser->own_proposals()->where('status', 'in_progress')->count();
    }

    public function getCoProposalCount(CatalystUser $catalystUser)
    {
        $allProposals = $catalystUser->proposals()->where('status', 'in_progress')->count();
        $ownProposals = $this->getOutsandingProposalCount($catalystUser);

        return $allProposals - $ownProposals;
    }

    public function getF10PrimaryProposalCount(CatalystUser $catalystUser)
    {
        return $catalystUser->own_proposals()->whereHas('fund', function ($q) {
            $q->whereHas('parent', function ($q) {
                $q->where('title', 'Fund 10');
            });
        })->count();
    }

    public function getF10CoProposalCount(CatalystUser $catalystUser)
    {
        $allProposals = $catalystUser->proposals()->whereHas('fund', function ($q) {
            $q->whereHas('parent', function ($q) {
                $q->where('title', 'Fund 10');
            });
        })->count();

        $ownProposals = $this->getF10PrimaryProposalCount($catalystUser);

        return $allProposals - $ownProposals;
    }
}
