<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\RewardsData;
use Exception;
use App\Models\Tx;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Reward;
use App\Enums\RoleEnum;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Jobs\ProcessUserRewardsJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\CardanoWalletService;
use Illuminate\Auth\AuthenticationException;

class RewardController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()){
            $rewards = $this->queryRewards($request->user());
        }

        return Inertia::render('Rewards',[
            'Rewards' => $request->user() ? RewardsData::collection($rewards) : []
        ]);
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'hash' => 'required|string|min:10',
        ]);

        // get first pending withdrawal from user
        $withdrawal = Withdrawal::pending()
            ->where('user_id', auth()->user()->getAuthIdentifier())
            ->firstOrFail();

        $tx = new Tx;
        $tx->hash = $request->hash;
        $tx->model_id = $withdrawal->id;
        $tx->user_id = auth()?->user()?->getAuthIdentifier();
        $tx->model_type = Withdrawal::class;
        $tx->save();

        return [$withdrawal];
    }

    public function process(Request $request)
    {
        // check if is a lido delegators
        if (! auth()->user()?->hasRole(RoleEnum::delegator()->value)) {
            //@todo wait for dust to be confirmed
            // add new Tx object and attach to reward object
            // outcome of this will set the reward model to waiting
        } else {
            $user = auth()?->user();
            if (! $user->wallet_address) {
                $user->wallet_addres = $request->input('address');
                $user->save();
            }
            ProcessUserRewardsJob::dispatch(
                auth()?->user(),
                $request->input('address') ?? $user->wallet_address
            );
        }
    }

    public function mintAddress()
    {
        $response = $this->mintAddressFromLucid();

        return response([
            'address' => $response?->address,
            'qr' => CardanoWalletService::generateQrCode($response?->address),
        ], 200);
    }

    /**
     * @throws AuthenticationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'nullable|bail|required_without:stake_address|email',
            'password' => 'nullable|bail|required_without:stake_address|min:5',
            'stake_address' => 'sometimes|required_without_all:email,password|min:13',
            'key' => 'sometimes|required_without_all:email,password|min:13',
            'signature' => 'sometimes|required_without_all:email,password|min:13',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return auth()->user();
        }

        if ((bool) $request->stake_address) {
            $user = User::where('wallet_stake_address', $request->stake_address)->first();

            if ((bool) $user) {
                Auth::login($user);

                return auth()->user();
            } else {
                return response()->json([
                    'message' => 'We are having trouble logging you in with your stake address. Try your email and password. Note: You will only be able to login after earning your first Lido reward.',
                ], 401);
            }
        }

        throw new AuthenticationException('Could not log user in.');
    }

    public function withdrawals()
    {
        $rewards = Reward::where('stake_address', auth()?->user()?->wallet_stake_address)
            ->where('status', 'issued')
            ->orderBy('created_at', 'desc')
            ->get()
            ?->groupBy('asset');

        $flattenedRewards = $rewards ? array_reduce($rewards->toArray(), 'array_merge', []) : [];

        return array_values($flattenedRewards);
    }

    protected function mintAddressFromLucid()
    {
        $seed = file_get_contents('/data/phuffycoin/wallets/mint/seed.txt');
        try {
            return Http::post(
                config('cardano.lucidEndpoint').'/wallet/address',
                compact('seed')
            )->throw()->object();
        } catch (Exception $e) {
            return null;
        }
    }

    public function queryRewards($user){

        return Reward::where('stake_address', $user?->wallet_stake_address)
                    ->where('status', 'issued')
                    ->orderBy('created_at', 'desc')->with('user')->paginate(12, ['*'], 'p')->setPath('/')->onEachSide(0);
    }
}
