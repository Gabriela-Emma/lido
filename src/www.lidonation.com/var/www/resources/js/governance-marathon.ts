// @ts-nocheck
import Alpine, {Alpine as AlpineType} from 'alpinejs'
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Tooltip from "@ryangjchandler/alpine-tooltip";
import persist from '@alpinejs/persist';
import focus from '@alpinejs/focus';
import Notice from "./lib/interfaces/Notice";
import {Axios, AxiosError} from "axios";

export {};
declare global {
    interface Window {
        Alpine: AlpineType;
        cardano: Cardano;
        delegationLearningModule: any;
        axios: Axios;
    }
}

Alpine.plugin(Clipboard);
Alpine.plugin(Tooltip);
Alpine.plugin(persist);
Alpine.plugin(focus);

Alpine.data('mobileMenu', function () {
    return {
        showing: false,
        show() {
            this.showing = true;
        },
        hide() {
            return this.showing = false;
        },
        toggle() {
            return this.showing = !this.showing;
        }
    }
}.bind(Alpine));
Alpine.data('cardanoMenu', function () {
    return {
        showing: false,
        show() {
            this.showing = true;
        },
        hide() {
            return this.showing = false;
        },
        toggle() {
            return this.showing = !this.showing;
        }
    }
}.bind(Alpine));
Alpine.data('governanceMarathon', function () {
    return {
        cardanoService: null,
        claimingPhuffy: false,
        claimingRewards: false,
        giveAwayEntered: false,
        giveAttendance: null,
        currPage: this.$persist('home'),

        delegating: false,
        delegationTransactionId: this.$persist(null).using(sessionStorage),

        environment: 'test',

        loadingBlocks: true,

        notices: [] ,

        parameters: null,
        phuffyPendingTxs: [],
        phuffyBalance: 0,
        poolDetails: null,
        poolBlocks: null,

        stakeAccount: null,
        stakeRewards: null,
        stakeRegistrations: null,

        user: null,
        userLoading: false,

        formData: {
            stake_address: null,
            reward_address: null,
            firstPrinciples: null,
            copperSeed: null,
            resiToken: null,
            cardaworlds: null,
            roundtable: null,
        },

        config: null,

        async init() {
        },
        get working () {
          return this.delegating || this.userLoading || this.claimingRewards || this.claimingPhuffy;
        },
        async submitToGiveaway(event){
            const formData = new FormData(event.target);
            const res = await window.axios.post(`/ta/create`, formData);
            if(res.status === 200 || res.status === 201) {
                this.formData = {};
                this.giveAwayEntered = true;
                this.giveAttendance = res.data;
            }
        },
        navigate(page: string) {
            this.currPage = page;
        },

        clearError(index) {
            if (this.notices.length === 1) {
                this.notices = [];
            } else {
                const notices = this.notices.splice(index, 1);
                this.notices = [...notices];
            }
        },
        pushError(e: Notice) {
            this.notices = [
                {
                    type: 'default',
                    ...e
                },
                ...this.notices
            ];
        }
    }
}.bind(Alpine));

require('./modal');

Alpine.start();

