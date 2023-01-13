// @ts-nocheck
import Alpine, {Alpine as AlpineType} from 'alpinejs'
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Tooltip from "@ryangjchandler/alpine-tooltip";
import persist from '@alpinejs/persist';
import focus from '@alpinejs/focus';
import WalletService from "./lib/services/WalletService";
import {C, Cardano} from "lucid-cardano";
import CardanoService from "./lib/services/CardanoService";
import Notice from "./lib/interfaces/Notice";
import {Axios, AxiosError} from "axios";
import BlockfrostKeysService from "./lib/services/BlockfrostKeysService";
import {walletLogin} from "./lib/utils/walletLogin";
import {globalVideoPlayer} from "./lib/utils/globalVideoPlayer";
import Plyr from 'plyr';
import KUTE from 'kute.js'
import {componentToggle} from "./lib/utils/componentToggle";

export {};
declare global {
    interface Window {
        Alpine: AlpineType;
        cardano: Cardano;
        delegationLearningModule: any;
        axios: Axios;
    }
}

const tween = KUTE.fromTo(
    '#hosky-blob1',
    {path: '#hosky-blob1'},
    {path: '#hosky-blob2'},
    {repeat: 999, duration: 3000, yoyo: true}
);
tween.start();

Alpine.plugin(Clipboard);
Alpine.plugin(Tooltip);
Alpine.plugin(persist);
Alpine.plugin(focus);

Alpine.data('hoskyVideo', function () {
    return {
        playing: false,

        init() {
            this.pitchPlayer = new Plyr(this.$refs.lidoHoskyPoolVideo);
        },
        play() {
            this.playing = true;
            this.pitchPlayer.play();
        }
    }
});


Alpine.data('everyEpoch', function () {
    return {
        quiz: null,
        submitting: false,
        quizSubmitted: false,
        answers: {},
        giveaway: null,
        ballotTx: null,
        ccv4BallotVerified: false,
        reward: null,
        seeYourLidoRewards: false,
        useHardwareWallet: false,
        ballotError: false,
        voteTx: null,

        get correct() {
            return this.answers[this.quiz?.answer]?.correctness === 'correct';
        },

        init() {
            document.querySelectorAll('.answer')
                .forEach((answer) => {
                    const _ans = JSON.parse(answer.dataset.answer);
                    this.answers[_ans.id] = _ans;
                });
        },

        async claimCcv4VoteReward(asset) {
            this.submitting = true;
            Livewire.emit('claimEveryEpochReward', asset);
            setTimeout(() => {
                this.submitting = false;
                this.seeYourLidoRewards = true;
            }, 3000);
        },

        async validateCcv4Vote(hardware = false) {
            this.submitting = true;
            try {
                let signature, tx;
                if (!hardware) {
                    signature = await (new WalletService())
                        .signMessage(this.walletName, Buffer.from('Every Epoch Ballot Verification')
                            .toString('hex')) as {};
                } else {
                    this.useHardwareWallet = true;
                    tx = this.voteTx;
                }

                const res = (await window.axios.post(`/api/ccv4/ballot`, {
                    'account': this.stakeAccount?.stake_address,
                    signature,
                    tx
                }));
                if (res?.data?.ballots?.length > 0) {
                    this.ccv4BallotVerified = true;
                    this.ballotTx = res?.data?.ballots[0]?.tx_hash;
                } else {
                    this.ballotError = true;
                    this.$dispatch('new-notice', {
                        name: 'Ballot Not Found',
                        message: `Could not verify your ballot, if you just voted please wait 15 mins then try again.
                        If you are using a hardware wallet make sure you are pasting the ballot mint transaction`,
                        type: 'error'
                    });
                }
                if (!!res?.data?.reward) {
                    this.reward = res?.data?.reward;
                    this.quizSubmitted = true;
                    this.seeYourLidoRewards = true;
                }
            } catch (e) {
                this.$dispatch('new-notice', { name: 'Error', message: e.message, type: 'error'});
            }
            this.submitting = false;
        },

        async submitResponse(event) {
            try {
                this.quiz = Object.fromEntries(new FormData(event.target));
                if (!this.correct) {
                    await this.submitQuiz(null);
                }
            } catch (e) {
                this.$dispatch('new-notice', e.message);
            }
        },

        async submitQuiz(asset) {
            try {
                this.submitting = true;
                this.quiz['stake_address'] = this.stakeAccount?.stake_address;
                this.quiz['wallet_address'] = this.stakeAccount?.wallet_address;
                const res = (await window.axios.post(`/api/quizzes/questions/answers/responses`, this.quiz));
                this.quiz['answer'] = res?.data?.question_answer_id;
                this.submitting = false;
                this.quizSubmitted = true;
                // this.$dispatch('quiz-submitted');
                if (asset) {
                    Livewire.emit('claimEveryEpochReward', asset);
                }
            } catch (e) {
                this.$dispatch('new-notice', e?.message);
            }
        }
    }
}.bind(Alpine));

Alpine.data('lidoRewards', function () {
    return {
        quiz: null,
        working: false,
        withdrawalsProcessed: null,
        withdrawals: null,

        init() {

        },

        getAssetLogo(reward) {
            if (!reward.asset_details?.metadata?.logo) {
                return null;
            }
            return `data:image/png;base64, ${reward.asset_details?.metadata?.logo}`;
        },

        getAssetTicker(reward) {
            return reward.asset_details?.metadata?.ticker;
        },

        getAssetName(reward) {
            return reward.asset_details?.metadata?.name || reward.asset_details?.asset_name;
        },

        async processWithdrawals() {
            this.working = true;
            try {
                (await window.axios.post(`/api/rewards/withdrawals/process`, {address: change_address}));
                setTimeout(async () => {
                    this.withdrawals = (await window.axios.post(`/api/rewards/withdrawals`))?.data;
                    location.reload();
                }, 3000);
            } catch (e) {
                this.$dispatch('new-notice', e.message);
            }
        },

        async withdraw() {
            this.working = true;
            try {
                this.withdrawals = (await window.axios.post(`/api/rewards/withdrawals`))?.data;
            } catch (e) {
                this.$dispatch('new-notice', e.message);
            }
            this.working = false;
        },
    }
}.bind(Alpine));

Alpine.data('mobileMenu', componentToggle.bind(Alpine));
Alpine.data('cardanoMenu', componentToggle.bind(Alpine));
Alpine.data('delegateToLido', function () {
    return {
        showRewards: false,

        cardanoService: null,

        claimingPhuffy: false,
        claimingRewards: false,
        claimStatusSet: false,

        claimPhuffySteps: [],
        claimPhuffyErrors: [],
        claimPhuffyManualTx: false,
        submittedPhuffycoinDepositTx: null,
        mintingTx: null,
        mintAddress: null,


        currPage: this.$persist('home'),

        delegating: false,
        delegationTransactionId: this.$persist(null).using(sessionStorage),

        environment: 'test',

        loadingBlocks: true,

        parameters: null,
        phuffyTxs: [],
        phuffyPendingTxs: [],
        phuffyBalance: 0,
        poolDetails: null,
        poolBlocks: null,

        refunding: false,
        refunded: false,

        stakeAccount: null,
        stakeRewards: null,
        stakeRegistrations: null,

        user: null,
        userLoading: false,

        working: false,
        wallet: null,
        walletBalance: null,
        walletName: this.$persist(null).using(localStorage),
        walletLoaded: false,
        walletLoading: false,
        walletService: null,

        config: null,

        async initPortal() {
            if (window.location.origin === 'https://www.lidonation.com') {
                this.environment = 'production';
            }
            try {
                this.parameters = await this.cardanoService.getParameters();
                this.walletLoaded = !!await this.getWalletBalance();
                this.stakeAccount = await this.cardanoService.getStakeAccount(<string>await this.walletService.getStakeAddress(this.walletName));
                this.stakeAccount.change_address = <string>await this.walletService.getAddress()
                this.stakeRewards = (await this.cardanoService.getStakeRewards(this.stakeAccount?.stake_address)).map((reward => ({
                    ...reward,
                    amount: this.numberFormat(reward?.amount / 1000000),
                    type: 'reward'
                }))).filter(r => r?.pool_id === this.poolDetails?.pool_id);

                await this.setLidoUser();
                await this.setPhuffyBalance();
            } catch (e) {
                console.log(e);
                // this.pushError({name: 'Error', message: e.toString(), type: 'error'} as Notice);
            }
            this.walletLoading = false;
            this.loadingBlocks = false;
        },
        async init() {
            try {
                this.walletService = new WalletService();
                const blockfrostKeysService = new BlockfrostKeysService();
                this.config = await blockfrostKeysService.getConfig();

                this.cardanoService = new CardanoService();
                this.poolDetails = await this.cardanoService.getPoolDetails();
                this.poolBlocks = await this.cardanoService.getPoolBlocks();
                this.loadingBlocks = false;

                await this.initPortal();
            } catch (e) {
                console.log(e);
            }

            Livewire.on('lidoRewardsLoaded', () => {
                alert('A post was added with the id of: ');
            });
        },
        get delegationTx() {
            if (window.location.origin === 'https://www.lidonation.com') {
                return `https://cardanoscan.io/transaction/${this.delegationTransactionId}`;
            }
            return `https://testnet.cardanoscan.io/transaction/${this.delegationTransactionId}`;
        },
        get isDelegatedToLido() {
            if (!this.walletName) {
                return false;
            }
            if (!this.stakeAccount) {
                return false;
            }
            if (!!this.delegationTransactionId) {
                return true;
            }

            return this.stakeAccount?.pool_id && this.stakeAccount?.pool_id == this.walletService.poolId;
        },
        get poolLiveStake() {
            return this.numberFormat(this.poolDetails?.live_stake / 1000000);
        },
        get epochsDelegated() {
            if (!this.parameters || !this.stakeAccount) {
                return '-'
            }
            return this.parameters?.epoch - this.stakeAccount?.active_epoch;
        },
        get availableAdaRewards() {
            if (!this.stakeAccount) {
                return false
            }
            return this.numberFormat(this.stakeAccount?.withdrawable_amount / 1000000);
        },
        get controlledStake() {
            if (!this.stakeAccount) {
                return false
            }
            return this.numberFormat(this.stakeAccount?.controlled_amount / 1000000);
        },
        get working() {
            return this.delegating || this.userLoading || this.claimingRewards || this.claimingPhuffy;
        },
        get claimStep() {
            return this.claimPhuffySteps[this.claimPhuffySteps.length - 1];
        },
        navigate(page: string) {
            this.currPage = page;
        },
        async getWalletBalance() {
            if (!this.walletName) {
                this.walletBalance = null;
                return false;
            }
            try {
                this.walletLoading = true;
                this.walletBalance = await this.walletService.getBalance(this.walletName);
                const walletBalance = C.Value.from_bytes(Buffer.from(this.walletBalance, 'hex')).coin().to_str();
                if (!!walletBalance) {
                    this.walletBalance = (walletBalance / 1000000).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
                this.walletLoading = false;
                return true;
            } catch (e) {
                this.$dispatch('new-notice', e.toString());
            }
        },
        async enableWallet(wallet) {
            this.walletLoading = true;
            this.walletName = wallet;
            try {
                await this.walletService.connectWallet(this.walletName);
                await this.getWalletBalance();
                this.walletLoaded = true;
                await this.initPortal();
            } catch (e) {
                this.$dispatch('new-notice', e.toString());
            }

        },
        async delegate(wallet) {
            this.delegating = true;
            this.walletName = wallet;
            try {
                this.delegationTransactionId = await this.walletService.delegate(this.walletName);

                if (!!this.delegationTransactionId) {
                    //@todo turn this.delegationTransactionId in a hyperlink text
                    this.$dispatch('new-notice', {
                        name: 'Delegation Successful',
                        message: this.delegationTransactionId,
                        type: 'success'
                    } as Notice);
                } else {
                    this.$dispatch('new-notice', {
                        name: 'Delegation Error',
                        message: 'Delegation failed. Please try again.',
                        type: 'error'
                    } as Notice);
                }
            } catch (e) {
                this.$dispatch('new-notice', e.message);
            }
            this.delegating = false;
        },
        async claimPhuffyManually() {
            if (!this.mintAddress?.address) {
                await this.setMintAddress();
            }
            this.claimPhuffyManualTx = true;
        },
        async startClaimingPhuffies() {
            this.claimingPhuffy = true;
            await this.setMintAddress();
            await this.getClaimStatus();
            this.claimingPhuffy = false;
            this.claimStatusSet = true;

        },
        async getClaimStatus() {
            try {
                let tx = this.phuffyPendingTxs[0];
                switch (tx?.status || null) {
                    case 'processing':
                        this.claimPhuffySteps = [0, 1];
                        break;
                    case 'minting':
                        this.claimPhuffySteps = [0, 1, 2];
                        break;
                    case 'minted':
                        this.claimPhuffySteps = [0, 1, 2, 3];
                        break;
                    default:
                        if (this.claimPhuffySteps.length < 1) {
                            this.claimPhuffySteps = [0];
                        }
                }

                const res = (await window.axios.post(`/api/phuffycoin/claim/status`));
                const items = res?.data?.items || [];
                if (items.length > 0) {
                    this.setPhuffyTxs(items);
                    tx = this.phuffyPendingTxs[0];
                    this.submittedPhuffycoinDepositTx = tx?.deposit_tx;
                    this.mintingTx = tx?.minting_tx;
                    if (['processing', 'minting'].includes(tx?.status)) {
                        this.claimingPhuffy = false;
                        await this.delay(5000);
                        await this.getClaimStatus();
                    }
                }
            } catch (e) {
                if (this.claimStatusSet) {
                    if (e?.response && e.response.status === 404) {
                        await this.delay(5000);
                        await this.getClaimStatus();
                        return;
                    }

                    const err = {name: e.name, message: e?.response?.data?.message || e.message || e, type: 'error'};
                    this.$dispatch('new-notice', err);
                    // @todo when do we kill the claim ui and direct to support
                    // this.claimPhuffyErrors.push(err);
                }
            }
            this.claimStatusSet = true;
        },
        seeRewards(reload = false) {
            this.showRewards = true;
            this.navigate('rewards');
            window.location.assign('#delegator-portal');
            if (reload === true) {
                location.reload();
            }
        },
        async claimPhuffies() {
            this.claimingPhuffy = true;
            try {
                if (!this.mintAddress?.address) {
                    await this.setMintAddress();
                }
                const rawTx = await this.walletService.payToAddress(this.mintAddress.address, {lovelace: 2000000n});
                const signedTx = await rawTx.sign().complete();
                this.submittedPhuffycoinDepositTx = await signedTx.submit();
                this.claimPhuffySteps.push(1);

                // push tx id back to server
                (await window.axios.post(`/api/phuffycoin/claim`, {
                    depositTx: this.submittedPhuffycoinDepositTx,
                    mintTxs: this.phuffyPendingTxs.filter(tx => ['pending', 'processing', 'minting'].includes(tx.status)).map(tx => tx.id)
                }))?.data?.items;
            } catch (e) {
                if (e?.response && e.response.status !== 404) {
                    this.$dispatch('new-notice', {
                        name: e.name,
                        message: e?.response?.data?.message || e.message || e,
                        type: 'error'
                    });
                }
            }
            await this.getClaimStatus();
            this.claimPhuffySteps = [0, 1, 2, 3];

            this.$dispatch('new-notice', {
                name: 'Voting Coming Soon',
                message: 'Check your wallet newly minted PHUFFY. Voting features coming soon.',
                type: 'success'
            } as Notice);
            this.claimingPhuffy = false;
        },
        async withdrawReward() {
            this.claimingRewards = true;
            try {
                const transactionId = await this.walletService.withdrawRewards(this.stakeAccount?.withdrawable_amount || null);
                this.$dispatch('new-notice', {
                    name: 'Transaction Successful',
                    message: `tx: ${transactionId}`,
                    type: 'success'
                } as Notice);
            } catch (e) {
                this.$dispatch('new-notice', {
                    name: e.name,
                    message: e?.response?.data?.message || e.message || e,
                    type: 'error'
                });
            }
            this.claimingRewards = false;
        },
        async withdrawLidoRewards() {
            this.claimingRewards = true;
            try {
                const transactionId = 222; // await this.walletService.withdrawRewards(this.stakeAccount?.withdrawable_amount || null);
                this.$dispatch('new-notice', {
                    name: 'Transaction Successful',
                    message: `tx: ${transactionId}`,
                    type: 'success'
                } as Notice);
            } catch (e) {
                this.$dispatch('new-notice', {
                    name: e.name,
                    message: e?.response?.data?.message || e.message || e,
                    type: 'error'
                });
            }
            this.claimingRewards = false;
        },
        async setMintAddress() {
            this.mintAddress = (await window.axios.post(`/api/phuffycoin/mint-address`))?.data;
        },
        async setLidoUser() {
            try {
                this.userLoading = true;
                const res = await window.axios.get(`/api/delegators/current`);
                const userData = res?.data;

                // confirm wallet_address from blockfrost matches stake_address in db
                const blockfrostStakeAddress = await this.cardanoService.getStakeAddress(this.stakeAccount.change_address);
                const addressConfirmed = await this.walletService.confirmWalletOwnership(blockfrostStakeAddress, userData.wallet_stake_address);

                if (addressConfirmed) {
                    this.user = userData
                    console.log(`Wallet ownership verified.`)
                } else {
                    console.log('Wallet ownership verification error.')
                }
            } catch (e: AxiosError | any) {
                console.log({e});
            }
            this.userLoading = false;
        },
        async setPhuffyBalance() {
            try {
                const res = await window.axios.get(`/api/phuffycoin`);
                this.setPhuffyTxs(res?.data?.items);
                this.phuffyBalance = this.phuffyPendingTxs
                    .filter(tx => ['pending', 'processing', 'minting'].includes(tx.status))
                    .reduce((a, b) => a + b.amount, 0);
            } catch (e: AxiosError | any) {
                console.log({e});
            }
            this.userLoading = false;
        },
        async walletLogin(wallet: string) {
            try {
                this.user = await walletLogin(wallet, this.stakeAccount.stake_address, 'Lido Delegator Login');
                await this.setPhuffyBalance();
                this.navigate('home');
                location.reload();
            } catch (e: AxiosError | any) {
                console.log({e});
                this.$dispatch('new-notice', {
                    name: e.name,
                    message: e?.response?.data?.message || e.message,
                    type: 'error'
                });
            }

        },
        async login(event) {
            try {
                this.userLoading = true;
                const user = {
                    ...Object.fromEntries(new FormData(event.target))
                };
                const res = await window.axios.post(`/api/delegators/login`, user);
                this.user = res?.data;
                await this.setPhuffyBalance();
                this.navigate('home');
                location.reload();
            } catch (e: AxiosError | any) {
                this.$dispatch('new-notice', {
                    name: e.name,
                    message: e?.response?.data?.message + " Reloading so you can try again." || e.message + " Reloading so you can try again.",
                    type: 'error'
                })
                setTimeout(()=>{ location.reload(); }, 2000);
            }
            this.userLoading = false;
        },
        async logout() {
            try {
                this.userLoading = true;
                await window.axios.post(`/api/delegators/logout`);
                this.navigate('home');
                this.user = null;
                location.reload();
            } catch (e: AxiosError | any) {
                this.$dispatch('new-notice', {
                    name: e.name,
                    message: e?.response?.data?.message || e.message,
                    type: 'error'
                })
                console.log({e});
            }
            this.userLoading = false;
        },
        async createAccount(event) {
            this.userLoading = true;
            const user = {
                stake_address: this.stakeAccount.stake_address,
                wallet_address: this.stakeAccount.wallet_address,
                ...Object.fromEntries(new FormData(event.target))
            };
            try {
                const res = await window.axios.post(`/api/delegators/create`, user, {
                    headers: {
                        'Content-Type': 'multipart/json'
                    }
                });
                this.user = res.data;
                this.navigate('home');
            } catch (e: AxiosError | any) {
                this.$dispatch('new-notice', {
                    name: e.name,
                    message: e?.response?.data?.message || e.message,
                    type: 'error'
                })
                console.log({e});
            }
            this.userLoading = false;
        },
        setPhuffyTxs(items) {
            this.phuffyTxs = items;
            this.phuffyPendingTxs = this.phuffyTxs
                .filter(tx => ['pending', 'processing', 'minting'].includes(tx.status));
        },
        numberFormat(value) {
            // Nine Zeroes for Billions
            return Math.abs(Number(value)) >= 1.0e+9

                ? (Math.abs(Number(value)) / 1.0e+9).toFixed(2) + "B"
                // Six Zeroes for Millions
                : Math.abs(Number(value)) >= 1.0e+6

                    ? (Math.abs(Number(value)) / 1.0e+6).toFixed(2) + "M"
                    // Three Zeroes for Thousands
                    : Math.abs(Number(value)) >= 1.0e+3

                        ? (Math.abs(Number(value)) / 1.0e+3).toFixed(2) + "K"

                        : Math.abs(Number(value));
        },
        delay(ms) {
            return new Promise(res => setTimeout(res, ms));
        }
    }
}.bind(Alpine));

window.globalVideoPlayer = globalVideoPlayer;

document.addEventListener('livewire:load', function () {
    console.log(this.$wire);
});

window.Alpine = Alpine;
window.Alpine.start();
