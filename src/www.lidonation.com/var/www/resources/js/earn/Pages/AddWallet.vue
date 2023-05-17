<template>
    <Modal :show="show">
        <div class="z-50 bg-labs-red flex flex-col">
            <header class="p-6 bg-labs-black text-white">
                <h2>Add Wallet</h2>
            </header>

            <div class="px-8 py-16 sm:px-24">
                <h2 class="text-xl text-white xl:text-2xl text-center">Lets Add Your Wallet</h2>
                <div class="bg-labs-black rounded-sm flex justify-center w-64 py-4">
                    <ConnectWallet @wallet-updated="handleWalletUpdated($event)" :background-color="'bg-labs-black'"/>
                </div>
            </div>
        </div>
    </Modal>
</template>
<script lang="ts" setup>
import Modal from "../../global/Shared/Components/Modal.vue";
import ConnectWallet from "../../global/Shared/Components/ConnectWallet.vue";
import axios from "../../lib/utils/axios";
import {useLearnerDataStore} from "../store/learner-data-store";
import route from "ziggy-js";
import Wallet from "../../catalyst-explorer/models/wallet";
import {ref} from "vue";
import {useModal} from "momentum-modal";

let show = ref(true);

const {close} = useModal();

function handleWalletUpdated(wallet: Wallet) {
    if (!wallet.stakeAddress || !wallet.address) {
        console.log('wallet not updated::');
        return;
    }
    axios.post(route('earnApi.wallet.add'),
        {
            wallet_address: wallet.address,
            wallet_stake_address: wallet.stakeAddress
        }).then((res) => {
        if (res.status === 200) {
            let learnerDataStore = useLearnerDataStore();
            learnerDataStore.getLearnerData();
            close();
        }
    })
}

</script>
