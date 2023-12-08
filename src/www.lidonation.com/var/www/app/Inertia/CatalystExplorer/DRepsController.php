<?php

declare(strict_types=1);

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\CatalystVoter;
use App\Models\CatalystExplorer\DRep;
use App\Models\Signature;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Inertia\Response;

class DRepsController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render(
            'DReps',
            ['crumbs' => [['label' => 'dReps']]]
        );
    }

    public function signUp(): Response
    {
        return Inertia::render('DRepsSignUp', ['crumbs' => [['label' => 'dReps', 'link' => route('catalyst-explorer.dReps.index')], ['label' => 'Sign up']]]);
    }

    public function store(Request $request): void
    {
        // validate user can bote
        $validDrep = $this->isVoter($request->stakeAddress);

        if (!$validDrep) {
            abort(400, 'Not valid to be a dRep.');
        }

        // get or make lido user
        $dRepUser = auth()?->user();

        if (!$dRepUser) {
            //@todo if user already exists with email, bail and let the user know... tell to sign in
            $userWithEmailExists = User::where('email', $request->email)->first();

            $dRepUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->signature),
                'bio' => $request->platformStatement,
            ]);
        }

        // @todo lets make sure signatures are unique
        $signature = new Signature([
            'wallet_signature' => $request->signature,
            'stake_address' => $request->stakeAddress,
        ]);

        // Create dREp Profile
        $catalystDrep = DRep::whereRelation('catalyst_voter', 'stake_pub', $request->stakeAddress)
            ->orWhere('user_id', $dRepUser->id)
            ->first();
        if ( $catalystDrep) {
            new DRep([
                'wallet_signature' => $request->signature,
                'stake_address' => $request->stakeAddress,
                'user_id' => $dRepUser->id
            ]);
        }

        $dRepUser->signatures()->save($signature);
    }

    private function isVoter($stakeKey): bool
    {
        $voterProfiles = CatalystVoter::where('stake_pub', $stakeKey)->get();
        $votingPowers = $voterProfiles->map(fn($vp) => ($vp->voting_powers))->collapse();
        $voterVotes =  $votingPowers->map(fn($vp) => ((int) $vp->consumed))->sum();

         return $voterVotes >= 1;


//        $votingRegistrations = $voter->voting_powers;
//
//        $votedTwiceOrMore = false;
//        $consumedCount = 0;
//
//        if ($votingRegistrations->count() >= 1) {
//            foreach ($votingRegistrations as $votingRound) {
//                if ($votingRound->consumed) {
//                    $consumedCount++;
//
//                    if ($consumedCount >= 1) {
//                        $votedTwiceOrMore = true;
//                        break;
//                    }
//                }
//            }
//        }
//
//        return $votedTwiceOrMore;
    }
}
