<?php declare(strict_types=1);

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\CatalystVoter;
use App\Models\Signature;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class DRepsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render(
            'DReps',
            ['crumbs' => [['label' => 'dReps']]]
        );
    }

    public function signUp()
    {
        return Inertia::render('DRepsSignUp', ['crumbs' => [['label' => 'dReps sign up']]]);
    }

    public function store(Request $request)
    {
        $existingUser = User::where('email', $request->email)->first();

        $validDrep = $this->isVoter($request->stakeAddress);


        if (!$validDrep) {
            abort(400, 'Not valid to be a dRep.');
        }
        if ($existingUser) {
            $signature = new Signature([
                'wallet_signature' => $request->signature,
                'platform_statement' => $request->platformStatement,
            ]);

            $existingUser->signatures()->save($signature);
        } else {

            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->signature),
            ]);

            $newSignature = new Signature([
                'wallet_signature' => $request->signature,
                'platform_statement' => $request->platformStatement,
            ]);

            $newUser->signatures()->save($newSignature);
        }
    }


    private function isVoter($stakeKey)
    {
        $voter = CatalystVoter::where('stake_pub', $stakeKey)->first();
        $votingRegistrations = $voter->voting_powers;

        $votedTwiceOrMore = false;
        $consumedCount = 0;

        if ($votingRegistrations->count() >= 2) {
            foreach ($votingRegistrations as $votingRound) {
                if ($votingRound->consumed) {
                    $consumedCount++;

                    if ($consumedCount >= 2) {
                        $votedTwiceOrMore = true;
                        break;
                    }
                }
            }
        }

        return $votedTwiceOrMore;
    }
}
