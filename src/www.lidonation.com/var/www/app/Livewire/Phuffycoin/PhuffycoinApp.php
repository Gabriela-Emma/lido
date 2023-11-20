<?php

namespace App\Livewire\Phuffycoin;

use App\Repositories\CauseRepository;
use App\Repositories\VoteRepository;
use App\Services\CardanoGraphQLService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Fluent;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Whoops\Exception\ErrorException;

#[Layout('layouts.phuffycoin')]
class PhuffycoinApp extends Component
{
    public $faqs;

    public $user;

    public $eligiblePhuffyTotal;

    public function mount(): void
    {
        $this->user = Auth::user();

    }

    public function getFrequentlyAskedQuestions(): void
    {
        $this->faqs = collect([
            [
                'question' => 'What is phuffycoin?',
                'answer' => "PHUFFY Coin is a LIDO Nation Labs community project. It's a voting token used to make crowd sourcing decisions about charitable giving.
                By using blockchain technology, the voting system is transparent, auditable and easy.",
            ],
            [
                'question' => 'How does PHUFFY get created?',
                'answer' => 'At the end of an epoch, half of LIDO pool margin is used to mint PHUFFY coins for charitable giving. PHUFFY are delivered directly from mint to delegation wallets.
                The PHUFFY you hold is worth ADA, when you vote for your favorite cause, you are both saying that you want your cause to receive our funding as well as saying an amount you controll for them receive.',
            ],

            [
                'question' => 'How much PHUFFY do I get?',
                'answer' => '',
            ],
            [
                'question' => 'How much 1 PHUFFY worth?',
                'answer' => "PHUFFY coin is only used to direct charitable giving. It is a voting token that represents real value on the Cardano blockchain.
                LIDO Nation sets aside HALF of our pool's earnings for charitable giving, and then we give it to our delegators to direct that giving.
                It is not possible to cash out PHUFFY coin.
                &nbsp;
                **For the techies**: PHUFFY coin is wrapped lovelaces. A lovelace is the smallest unit of accounting in Cardano.
                1 Million lovelaces = 1 ADA. By using wrapped lovelaces to fuel our giving engine, we can provide tracking, transparency, auditability, and pin point accuracy.
                &nbsp;
                When you use PHUFFY coin to vote and your cause wins, the PHUFFY coin gets burned, and the equivalent amount of ADA is cashed out and donated to your cause.",
            ],
            [
                'question' => 'Where can I buy PHUFFY coin?',
                'answer' => 'PHUFFY Coin is not listed on any exchanges. PHUFFY is not designed to be traded or hodled.
                The only way to get PHUFFY is to join a community that is using it to organize decentralized charitable giving.',
            ],
            [
                'question' => 'Is PHUFFY Coin only for LIDO Delegates?',
                'answer' => 'PHUFFY coin was born at LIDO Nation, and for now it lives here.
                PHUFFY Coin is working with other dreamers and builders to bring it to to other stake pools and communities..
                Check out PHUFFY coin [roadmap](/phuffycoin/roadmap) for more details.',
            ],
            [
                'question' => 'Why is it named PHUFFY?',
                'answer' => "LIDO Nation started with two people shooting the breeze. Darlington is a blockchain expert and creative whiz.
                Stephanie, known affectionately to friends as Phuffy, is a total newcomer with lots of questions. During one early conversation,
                Darlington tried to explain how it all worked by giving a fun, silly example: \"You could make a PHUFFY coin!\"
                &nbsp;
                Soon after that, LIDO Nation was born. It's a great place for newcomers to ask questions and learn from blockchain experts. And we made a PHUFFY coin!",
            ],
        ]);

    }

    /**
     * @throws GuzzleException
     */
    public function render(CardanoGraphQLService $graphQLService, CauseRepository $causeRepository, VoteRepository $voteRepository): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->getFrequentlyAskedQuestions();
        try {
            [$treasurerTxs, $treasurerAggregate] = $graphQLService->getAddressTxs([config('cardano.mint.addresses.treasurer')], null, true);
            [$governorTxs, $governorAggregate] = $graphQLService->getAddressTxs([config('cardano.mint.addresses.governor')], null, true);
            [$escrowTxs, $escrowAggregate] = $graphQLService->getAddressTxs([config('cardano.mint.addresses.escrow')], null, true);
            [$mintTxs, $mintAggregate] = $graphQLService->getPolicyMints(null, true);
            [$lidoDelegateNftTxs, $lidoDelegationNftAggregate] = $graphQLService->getPolicyMints(config('cardano.mint.policies.lido_delegate'), true);
        } catch (ErrorException|\Exception $e) {
            report($e);
        }

        return view('livewire.phuffycoin.phuffycoin-app')->with([
            'registeredUsers' => $lidoDelegationNftAggregate?->count,
            'causes' => $causeRepository->paginate(),
            'votes' => $voteRepository->all(),
            //            'faqs' => $faqs,
            'campaign' => new Fluent([
                'metrics' => new Fluent([
                    'phuffy' => new Fluent([
                        'participating',
                        'eligible' => humanNumber($mintAggregate?->sum?->quantity, 2),
                    ]),
                    'wallets' => new Fluent([
                        'participating',
                        'eligible' => $mintAggregate?->count,
                    ]),
                    'activities' => $mintTxs,
                ]),
            ]),
            'mints' => new Fluent([
                'txs' => $mintTxs,
                'aggregate' => $mintAggregate,
            ]),
            'wallets' => new Fluent([
                'user' => new Fluent([
                    'phuffy' => new Fluent([
                        'txs' => $graphQLService
                            ->getAddressesTokenUtxos(config('cardano.mint.policies.phuffycoin'))
                            ->map(function ($tx) {
                                $tx->type = 'PHUFFY';

                                return $tx;
                            }),
                    ]),
                ]),
                'treasurer' => new Fluent([
                    'balance' => humanNumber(
                        ($treasurerAggregate ?? null)?->sum?->value / 1000000,
                        2
                    ),
                    'txs' => $treasurerTxs ?? collect([]),
                    'txs_aggregate' => $treasurerAggregate ?? null,
                ]),
                'governor' => new Fluent([
                    'balance' => humanNumber(
                        ($governorAggregate ?? null)?->sum?->value / 1000000,
                        2
                    ),
                    'txs' => $governorTxs ?? collect([]),
                    'txs_aggregate' => $governorAggregate ?? null,
                ]),
                'escrow' => new Fluent([
                    'balance' => humanNumber(
                        ($escrowAggregate ?? null)?->sum?->value / 1000000,
                        2
                    ),
                    'txs' => $escrowTxs ?? collect([]),
                    'txs_aggregate' => $escrowAggregate ?? null,
                ]),
            ]),
        ]);

    }
}
