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
        $ownProposals = $this->getOutstandingProposalCount($catalystUser);

        return $allProposals - $ownProposals;
    }

    public function getF11PrimaryProposalCount(CatalystUser $catalystUser)
    {
        return $catalystUser->own_proposals()->whereHas('fund', function ($q) {
            $q->whereHas('parent', function ($q) {
                $q->where('title', 'Fund 11');
            });
        })->count();
    }

    public function getF11CoProposalCount(CatalystUser $catalystUser)
    {
        $allProposals = $catalystUser->proposals()->whereHas('fund', function ($q) {
            $q->whereHas('parent', function ($q) {
                $q->where('title', 'Fund 11');
            });
        })->count();

        $ownProposals = $this->getF11PrimaryProposalCount($catalystUser);

        return $allProposals - $ownProposals;
    }
}
