// @ts-nocheck
// //import Alpine, {Alpine as AlpineType} from 'alpinejs'
// import Clipboard from "@ryangjchandler/alpine-clipboard"
// import Tooltip from "@ryangjchandler/alpine-tooltip";
// import persist from '@alpinejs/persist';
// import CardanoWallet from "../../../www2/resources/js/lib/interfaces/CardanoWallet";
import '../scss/lido.scss'
import '../scss/_phuffycoin.scss';

export {};
declare global {
    interface Window {
        Alpine: AlpineType;
        cardano: CardanoWallet;
        delegationLearningModule: any;
    }
}

let typhon;
window.onload = () => {
    typhon = window.cardano.typhon;

    if (!typhon) {
        alert("Typhon Extension is not installed !");
    } else {
        // alert("Typhon Extension is installed!");
    }
};

// class Phuffycoin {
//     async init() {
//         const nami_lib = await import('nami-wallet-api')
//         const WASM_lib = await import('@emurgo/cardano-serialization-lib-browser/cardano_serialization_lib');
//         const Nami = await nami_lib.NamiWalletApi(
//             window.cardano,
//             null,
//             // "<blockfrost-api-key>",
//             WASM_lib
//         )
//         let txHash = await Nami.delegate({
//             poolId: "pool1fvxfg0pcr4umked5cx7jgczdajp70hrz5fsutzk338u0jljlfpy"
//         })
//     }
// }

// const phuffy = new Phuffycoin();
// phuffy.init();

Alpine.plugin(Clipboard);
Alpine.plugin(Tooltip);
Alpine.plugin(persist);
Alpine.data('delegationLearningModule', function () {
    return {
        networkId: null,
        step: this.$persist(0).using(sessionStorage),
        walletName: this.$persist(null).using(sessionStorage),
        wallet: null,
        walletService: null,
        delegationTransactionId: null,
        errors: [],
        init: function () {
            // this.walletService = new WalletService();
            // this.wallet = this.walletService.getWallet();
            console.log("tytytyt");
            
        },
        vote: function () {
            console.log('vote');
        },
        delegate: async function (wallet) {
            // this.errors = [];
            // try {
            //     this.delegationTransactionId = await this.walletService.delegate(wallet);
            //     if (this.delegationTransactionId === true) {
            //         this.step = 10;
            //     } else {
            //         this.errors.push('Delegation failed. Please try again.');
            //     }
            // } catch (e) {
            //     this.errors.push(e.message || e.info);
            // }
        }
    }
}.bind(Alpine));

window.Alpine = Alpine;
window.onload = () => {
    Alpine.start();
}

