import Alpine from 'alpinejs'
import Chart from 'chart.js/auto';
import Clipboard from "@ryangjchandler/alpine-clipboard"
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus';
import LZString from 'lz-string';
import {groupBy, difference, reject, some, map, flatten, uniq, uniqBy, trim, filter, includes, omit} from "lodash";
import persist from '@alpinejs/persist';
import Plyr from 'plyr';
import Rellax from 'rellax/rellax';
import {Splide} from '@splidejs/splide';
import Tooltip from "@ryangjchandler/alpine-tooltip";
import {Video} from '@splidejs/splide-extension-video';
import {WordCloudController, WordElement} from 'chartjs-chart-wordcloud';
import {cardanoWallet} from "@/lib/utils/cardanoWallet";
import WalletService from "@/lib/services/WalletService";
import {globalVideoPlayer} from "@/lib/utils/globalVideoPlayer";
import tippy from "tippy.js";
import masonry from 'alpinejs-masonry';

Chart.register(WordCloudController, WordElement);
window.Alpine = Alpine;
window.Chart = Chart;
Alpine.plugin(Clipboard);
Alpine.plugin(Tooltip);
Alpine.plugin(persist);
Alpine.plugin(focus);
Alpine.plugin(collapse);
Alpine.plugin(masonry);

window.comment = function comment(comment) {
    return {
        replying: false,
        comment: JSON.parse(comment),
        reply() {
            this.replying = true;
            Livewire.emit('replyToComment', this.comment.id);
        }
    }
}

window.glossary = function glossary() {
    return {
        showing: null,
        show(index) {
            this.showing = index;
        },
        hide(index) {
            return this.showing !== index;
        },
        isShowing(index) {
            return this.showing === index;
        },
    }
}

window.articleRecorder = function articleRecorder(articleSlug, locale) {
    return {
        articleSlug,
        locale,
        playing: false,
        recording: false,
        recordedChunks: [],
        downloadLink: null,
        mediaRecorder: null,
        working: false,
        errors: [],
        startOrStopRecording() {
            if (this.recording) {
                this.stopRecording();
                return null;
            }

            if (this.mediaRecorder && this.mediaRecorder.state === 'recording' &&
                this.recordedChunks &&
                !this.recording) {
                this.mediaRecorder.resume();
            } else {
                if (!this.mediaRecorder) {
                    navigator.mediaDevices.getUserMedia({audio: true, video: false})
                        .then((stream) => this.startMediaRecorder(stream));
                }
            }
        },
        playback() {
            if (this.playing) {
                this.pausePlayback();
                return null;
            }

            document.getElementById('article-recorded-draft').play();
            this.playing = true;
        },
        pausePlayback() {
            document.getElementById('article-recorded-draft').pause();
            this.playing = false;
        },
        stopPlayback() {
            if (this.playing) {
                document.getElementById('article-recorded-draft').stop();
                this.playing = false;
            }
        },
        pauseRecording() {
            this.mediaRecorder.pause();
        },
        stopRecording() {
            this.working = true;
            if (this.recording) {
                this.mediaRecorder.stop();
                this.recording = false;
                setTimeout(() => this.saveRecording(), 2000)
            }
        },
        stopRecordingNPLaying() {
            this.recording = false;
            this.playing = false;
        },
        startMediaRecorder(stream) {
            this.mediaStream = stream;
            this.mediaRecorder = new MediaRecorder(stream, {
                mimeType: 'audio/webm'
            });
            this.mediaRecorder.addEventListener('dataavailable', (e) => this.saveChunks(e));
            this.recording = true;
            this.mediaRecorder.start();
        },
        saveRecording() {
            this.downloadLink = URL.createObjectURL(new Blob(this.recordedChunks));
            const link = document.getElementById('download-article-recorded-draft');
            link.href = this.downloadLink;
            link.download = this.articleSlug + '.wav';
            this.stopRecordingNPLaying();
            this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
            this.working = false;
        },
        saveChunks(e) {
            if (e.data.size > 0) {
                this.recordedChunks.push(e.data);
            }
        },
        reset() {
            this.stopRecordingNPLaying();
            this.recordedChunks = [];
            this.downloadLink = null;
            this.mediaRecorder = null;
            this.working = false;
            this.errors = [];
        },
        send() {
            this.errors = [];
            if (!this.recordedChunks) {
                return null;
            }
            this.working = true;
            this.stopRecordingNPLaying();
            const formData = new FormData();
            const fileName = this.articleSlug + '.wav';
            const fileObject = new File(this.recordedChunks, fileName, {
                type: 'audio/wav'
            });
            formData.append('media', fileObject);
            formData.append('filename', fileObject.name);
            formData.append('collection', 'audio');

            window.axios.post(`/${this.locale}/posts/${this.articleSlug}/audio`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res) => {
                Livewire.emit('recordingSubmitted');
                this.reset();
            }).catch((reason) => {
                this.working = false;
                this.errors.push(reason.response.statusText);
                this.errors
                    .push(
                        'Sorry this happened. Please <a download="' + this.articleSlug + '.wav' + '" href="' + this.downloadLink + '">download</a> the recording and email the file to hello@lidonation.com'
                    );
                console.error(reason.response.data.message);
            })
        }
    };
}

window.lidoStripePayment = function lidoStripePayment() {
    return {
        paymentSuccessful: false,
        makingPayment: false,
        tab: 'default',
        amount: 0,
        collectPayment() {
            this.makingPayment = true;
            this.amount = document.getElementById('donation-amount').value;
            this.makePayment();
        },
        payWithStripe() {
            this.tab = 'stripe';
        },
        payWithCrypto() {
            this.tab = 'crypto';
        },
        orderComplete(result) {
            this.loading(false);
            this.makingPayment = false;
            this.paymentSuccessful = true;
        },
        loading(isLoading) {
            if (isLoading) {
                // Disable the button and show a spinner
                document.querySelector("button").disabled = true;
                document.querySelector("#spinner").classList.remove("hidden");
                document.querySelector("#button-text").classList.add("hidden");
            } else {
                document.querySelector("button").disabled = false;
                document.querySelector("#spinner").classList.add("hidden");
                document.querySelector("#button-text").classList.remove("hidden");
            }
        },
        payWithCard(stripe, card, clientSecret) {
            this.loading(true);
            stripe
                .confirmCardPayment(clientSecret, {
                    payment_method: {
                        card: card
                    }
                })
                .then(result => {
                    if (result.error) {
                        // Show error to your customer
                        this.showError(result.error.message);
                    } else {
                        // The payment succeeded!
                        this.orderComplete(result);
                    }
                });
        },
        showError(errorMsgText) {
            this.loading(false);
            const errorMsg = document.querySelector("#card-error");
            errorMsg.textContent = errorMsgText;
            setTimeout(() => {
                errorMsg.textContent = "";
            }, 4000);
        },
        makePayment() {
            // Disable the button until we have Stripe set up on the page
            document.getElementById("submitStripeDonation").disabled = true;

            // The items the customer wants to buy
            const purchase = {
                amount: this.amount
            };

            window.axios.post('/stripe/get-intent', purchase, {
                headers: {
                    "Content-Type": "application/json"
                }
            }).then((res) => {
                const elements = stripe.elements();
                const style = {
                    base: {
                        color: "#578AE4",
                        fontFamily: 'Arial, sans-serif',
                        fontSmoothing: "antialiased",
                        fontSize: "16px",
                        "::placeholder": {
                            color: "#456eb6"
                        }
                    },
                    invalid: {
                        fontFamily: 'Arial, sans-serif',
                        color: "#b6456e",
                        iconColor: "#cd4e7c"
                    }
                };
                const card = elements.create("card", {style: style});
                // Stripe injects an iframe into the DOM
                card.mount("#donation-card-element");
                card.on("change", function (event) {
                    // Disable the Pay button if there are no card details in the Element
                    document.getElementById("submitStripeDonation").disabled = event.empty;
                    document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
                });
                const form = document.getElementById("donation-payment-form");

                form.addEventListener("submit", (event) => {
                    event.preventDefault();
                    // Complete payment when the submit button is clicked
                    this.payWithCard(stripe, card, res.data.client_secret);
                });
            })
        }
    }
}

window.addEventListener('analytics-event-fired', event => {
    if (event.detail?.code) {
        window.fathom.trackGoal(event.detail?.code, 0);
    }
});

let catSlider;
if (document.querySelector('.slider-splide')) {
    catSlider = new Splide( '.slider-splide', {
        type: 'loop',
        perPage: 4,
        pagePerMove: 1,
        focus: 'center',
        arrows: true,
        drag: 'free',
        pagination: false,
        breakpoints: {
        1030: {
            perPage: 3,
            gap: '.7rem',
            drag: 'free',
            padding: '2rem',
        },
        640: {
            perPage: 2,
            gap: '.7rem',
            padding: '2rem',
            drag: 'free',
        },
        480: {
            perPage: 1,
            gap: '.7rem',
            arrows: false,
            padding: '2rem',
            drag: 'free',
        },
        },
      } ).mount();
}

let minuteSplide;
if (document.querySelector('.minute-splide')) {
    minuteSplide = new Splide( '.minute-splide', {
        type: 'loop',
        perPage: 3,
        pagePerMove: 1,
        focus: 'center',
        arrows: true,
        drag: 'free',
        pagination: false,
        breakpoints: {
        1030: {
            perPage: 2,
            gap: '.7rem',
            padding: '2rem',
            drag: 'free',
        },
        480: {
            perPage: 1,
            gap: '.7rem',
            padding: '2rem',
            arrows: false,
            drag: 'free',
        },
        },
      } ).mount();
}

let secondarySlider, primarySlider;
if (document.getElementById('proposal-secondary-slide')) {
    secondarySlider = new Splide('#proposal-secondary-slide', {
        rewind: true,
        fixedWidth: 100,
        fixedHeight: 64,
        isNavigation: true,
        gap: 10,
        focus: 'left',
        arrows: false,
        pagination: false,
        cover: true,
        breakpoints: {
            '600': {
                fixedWidth: 66,
                fixedHeight: 40,
            }
        }
    }).mount();
}
if (document.getElementById('proposal-primary-slide')) {
    primarySlider = new Splide('#proposal-primary-slide', {
        type: 'fade',
        heightRatio: 0.3,
        pagination: false,
        arrows: false,
        height: 640,
        cover: true,
        disableOverlayUI: false,
        lazyLoad: 'sequential',
        breakpoints: {
            1650: {
                height: 580,
            },
            960: {
                height: 270,
            },
        },
        video: {
            loop: false,
            playerOptions: {
                youtube: {},
            }
        }
    });
}

if (
    document.getElementById('proposal-primary-slide') &&
    document.getElementById('proposal-secondary-slide')
) {
    primarySlider.sync(secondarySlider).mount({Video});
} else {
    // primarySlider.mount({Video});
}

window.translator = function translator(translationId) {
    return {
        translationId,
        savingDraft: false,
        publishing: false,
        saveDraftsInterval: null,
        content: null,
        autoGenerateLanguages: ['en', 'es', 'fr', 'de', 'ja', 'it', 'pt', 'ru', 'zh'],

        get tooltip() {
            if (!!this.content) {
                return 'Disabled because editor is not empty.';
            }
            return 'Generate machine translation.'
        },

        get canAutoGenerate() {
            return !this.content;

        },

        init() {
            let editor = new SimpleMDE({
                element: this.$refs[`editor-${translationId}`],
                promptURLs: true,
                spellChecker: false,
                autofocus: true,
                autosave: {
                    enabled: true,
                    uniqueId: `translation-editor-${this.translationId}`,
                    delay: 1000,
                },
            });

            if (editor.value().trim().length <= 0) {
                editor.value(this.$refs[`content-${translationId}`].textContent.trim());
            }

            editor.codemirror.on('change', () => {
                this.content = editor.value();
            });

            editor.codemirror.on('focus', () => {
                this.saveDrafts();
            });

            editor.codemirror.on('blur', () => {
                clearInterval(this.saveDraftsInterval);
            });

            this.content = editor.value();

            Livewire.on('translate-content', (args) => {
                if (this.translationId !== args.id) {
                    return;
                }
                editor.value(args.content);
                this.$refs[`updated-${translationId}`].textContent = `Last updated: ${args.updated}`;
            });
        },
        saveDraft() {
            this.savingDraft = true;
            if (this.content.length > 0) {
                Livewire.emit('submitTranslation', this.translationId, this.content);
            }
        },
        translate() {
            clearInterval(this.saveDraftsInterval);
            Livewire.emit('submitTranslation', this.translationId, this.content, true);
        },
        preTranslate() {
            this.savingDraft = false;
            if (!!this.content) {
                return null;
            }
            Livewire.emit('preTranslate', this.translationId);
        },
        saveDrafts() {
            if (!this.saveDraftsInterval) {
                this.saveDraftsInterval = setInterval(this.saveDraft.bind(this), 60000);
            }
        },
    }
}

Alpine.store('vt', {
    proposals: Alpine.$persist([]).as('proposals'),

    init() {
        // this.on = window.matchMedia('(prefers-color-scheme: dark)').matches
    },

    remove(proposal) {
        this.proposals = reject([...this.proposals], ['id', proposal.id]);
        return this.proposals;
    },

    upserts(proposals) {
        this.proposals = uniqBy([...this.proposals, ...proposals], 'id');
        window.fathom.trackGoal('6Z0FGVGD', proposals?.length || 1);
        return this.proposals;
    },

    upsert(proposal) {
        this.proposals = uniqBy([...this.proposals, proposal], 'id');
        window.fathom.trackGoal('6Z0FGVGD', 1);
        return this.proposals;
    },

    toggleUpsert(proposal) {
        if (some(this.proposals, {'id': proposal.id})) {
            this.remove(proposal);
        } else {
            this.upsert(proposal);
        }
        return this.proposals;
    },

    toggle(proposal) {
        let proposals = [...this.proposals];
        if (some(proposals, {'id': proposal.id, bookmark: proposal.bookmark})) {
            proposals = reject(this.proposals, ['id', proposal.id]);
        } else {
            proposals = reject(this.proposals, ['id', proposal.id]);
            if (proposal?.bookmark === 'downvote') {
                proposals = [...proposals, proposal];
            } else if (proposal?.bookmark === 'upvote') {
                proposals = [...proposals, proposal];
            }
        }

        this.proposals = [...proposals];
        return this.proposals;
    }
});

window.voterTool = function voterTool() {
    return {
        vote: null,
        proposals: [],
        newLabels: '',
        selectedLabels: [],
        addingLabelTo: null,

        addingLabel: false,
        creatingLabel: false,
        sharingBookmark: false,
        loadingSharedBookmark: false,

        bookmarkShareUrl: null,
        viewingShareUrl: false,
        generatingAnonShare: [],

        labelFilter: 'all',

        init() {
            this.setProposals();
        },

        async setProposals() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            let proposals, bookmarks;

            if (urlParams.has('list')) {
                try {
                    this.loadingSharedBookmark = true;
                    const res = await window.axios.get(`//${window.location.host}/project-catalyst/bookmarks/share/${urlParams.get('list')?.toString()}`);
                    bookmarks = JSON.parse(LZString.decompressFromEncodedURIComponent(res.data?.bookmark));
                } catch (e) {
                    console.log({e});
                }
                this.loadingSharedBookmark = false;

                if (!!bookmarks) {
                    if (typeof bookmarks[0] === 'string') {
                        this.labelFilter = bookmarks.shift();
                    }
                    bookmarks = bookmarks.map(b => ({
                        ...b,
                        fundHero: `https://storage.googleapis.com/www.lidonation.com${b.fundHero}`,
                        link: `${window.location.origin}${b.link}`
                    }));
                }
            }

            if (bookmarks && bookmarks.length > 0) {
                proposals = bookmarks;
                this.viewingShareUrl = true;
            } else {
                proposals = [...Alpine.store('vt').proposals];
            }

            if (this.labelFilter === 'all' || this.viewingShareUrl) {
                this.proposals = proposals;
            } else {
                this.proposals = [
                    ...filter(proposals, (p) => p?.labels && includes(p?.labels, this.labelFilter))
                ];
            }
            this.$dispatch('proposals-loaded');
        },

        get proposalsByFund() {
            return map(groupBy([...this.proposals], 'fundId'), function (group) {
                return {
                    fundId: group[0].fundId,
                    fundHero: group[0].fundHero,
                    fundTitle: group[0].fundTitle,
                    fundAmount: group[0].fundAmount,
                    fundProposalsCount: group[0].proposalsCount,
                    proposals: group
                }
            });
        },
        get labels() {
            return uniq(flatten(map(Alpine.store('vt').proposals, 'labels'))).sort();
        },

        addLabels(proposal) {
            this.addingLabelTo = proposal;
            this.addingLabel = true;
        },
        bookmarkProposal(proposal) {
            Alpine.store('vt').toggleUpsert(proposal);
            this.setProposals();
        },
        closeLabelEditor() {
            this.addingLabel = false;
            this.creatingLabel = false;
        },
        createLabel() {
            this.creatingLabel = true;
        },
        down(proposal) {
            proposal.bookmark = 'downvote';
            Alpine.store('vt').toggle(proposal);
            this.setProposals();
        },
        toggleSharingModal() {
            this.sharingBookmark = !this.sharingBookmark;
        },
        async share() {
            // Buffer.from(JSON.stringify([...this.proposals]), 'hex'); window.location.href
            // const bookmarks = Buffer.from(JSON.stringify([...this.proposals])).toString('hex');

            // const list = btoa(encodeURI(JSON.stringify([...this.proposals])));
            const proposals = [...this.proposals].map(p => ({
                ...omit(p, ['ideascale_link', 'labels']),
                link: (new URL(p.link.includes('http') ? p.link : `http:${p.link}`))?.pathname,
                fundHero: p.fundHero?.replace('https://storage.googleapis.com/www.lidonation.com', '')
            }));
            proposals.unshift(this.labelFilter);
            const bookmark = LZString.compressToEncodedURIComponent(JSON.stringify(proposals));
            this.generatingAnonShare.push(1);
            const res = await window.axios.post(`//${window.location.host}/project-catalyst/bookmarks/share`, {bookmark});
            this.generatingAnonShare.push(2);
            this.bookmarkShareUrl = `//${window.location.host}${window.location.pathname}?list=${res.data?.id}`;
            this.generatingAnonShare.push(3);
            this.generatingAnonShare.push(4);
        },
        filterProposals(label) {
            this.labelFilter = label;
            this.setProposals();
        },
        has(id, bookmark) {
            if (bookmark) {
                return !!Alpine.store('vt').proposals.find(p => p.id === id && p.bookmark === bookmark);
            }
            return !!Alpine.store('vt').proposals.find(p => p.id === id);
        },
        removeLabels(proposal, labels) {
            proposal.labels = difference(proposal?.labels || [], labels);
            Alpine.store('vt').upsert(proposal);
            this.setProposals();
        },
        saveLabels() {
            // get any potential new labels
            const newLabels = this.newLabels.split(',')

            // combine and assign new, selected, and already attached labels
            this.addingLabelTo.labels = filter((
                uniq([
                    ...this.addingLabelTo.labels || [],
                    ...this.selectedLabels,
                    ...newLabels]
                )
            ).map((l) => trim(l)));

            this.proposals = Alpine.store('vt').upsert(this.addingLabelTo);
            this.addingLabel = false;
            this.creatingLabel = false;
            this.setProposals();
        },
        up(proposal) {
            proposal.bookmark = 'upvote';
            Alpine.store('vt').toggle(proposal);
            this.setProposals();
        },
    }
}

window.bookmarksMenuLink = function () {
    return {
        getBookmarkCount() {
            return Alpine.store('vt').proposals?.length;
        }
    }
}

window.bookmarkButton = function () {
    return {
        bookMarked: null,
        updateBookMarked(id, bookmark) {
            if (bookmark) {
                this.bookMarked = Alpine.store('vt').proposals.find(p => p.id === id && p.bookmark === bookmark);
            } else {
                this.bookMarked = Alpine.store('vt').proposals.find(p => p.id === id);
            }
            return !!this.bookMarked;
        }
    }
}

window.proposalDrip = function proposal(proposal) {
    return {
        pitching: false,
        pitchPlayer: null,
        proposal: null,
        init() {
            if (this.$refs.proposalDrip?.dataset?.view && this.$refs.proposalDrip?.dataset?.view === 'pitch') {
                this.quickPitch();
                this.pitching = true;
            }
            if (this.$refs.proposalDrip?.dataset?.proposal) {
                this.proposal = JSON.parse(this.$refs.proposalDrip?.dataset?.proposal);
            }
        },
        quickPitch() {
            if (!this.pitchPlayer) {
                this.pitchPlayer = new Plyr(this.$refs.quickPitch);
            }
            this.pitchPlayer.togglePlay();
            this.pitching = !this.pitching;
        },
        closeQuickPitch() {
            if (this.pitchPlayer) {
                this.pitchPlayer.pause();
                this.pitching = !this.pitching;
            }
        }
    }
}

//@todo this does not work. Breaks contribute content content. need to reevaluate modals handling on the site.
// window.LivewireUIModal = LivewireUIModal;

window.buyNftDApp = function buyNftDApp() {
    return {
        steps: [0],
        minterAddress: null,
        wallet: null,
        amountReceived: null,
        mintTx: null,
        paymentTx: null,
        mintPrice: null,
        pastTxs: [],
        working: false,
        async init() {
            this.mintPrice = ((await window.axios.post(`/api/lido-minute-nft/mint-price`))?.data + 2) * 1000000;
        },
        get step() {
            if (this.steps.length < 1) {
                return null;
            }
            return this.steps[this.steps.length - 1];
        },
        async setMintAddress() {
            this.minterAddress = (await window.axios.post(`/api/lido-minute-nft/mint-address`))?.data;
        },
        async walletLoaded(wallet) {
            this.wallet = wallet;
            await this.setStatus();
        },
        async buyNft(id) {
            const walletService = new WalletService();
            await walletService.connectWallet(this.wallet?.name);
            this.working = true;
            if (!this.minterAddress?.address) {
                await this.setMintAddress();
            }

            const rawTx = await walletService.payToAddress(this.minterAddress?.address, {lovelace: BigInt(this.mintPrice)});
            const signedTx = await rawTx.sign().complete();
            this.paymentTx = await signedTx.submit();

            // send tx to backend
            const res = await window.axios.post(`/api/lido-minute-nft/mint`, {hash: this.paymentTx, episode: id});

            // start looping to get tx status every 5 seconds
            const intervalID = setInterval(async () => {
                await this.setStatus();
                if (['pending', 'paid', 'minting', 'minted'].includes(this.mintTx.status)) {
                    this.working = false;
                }
                if (this.mintTx.status === 'minted') {
                    clearInterval(intervalID);
                }
            }, 4000);
        },
        async setStatus() {
            try {
                const mintTx = await window.axios.post('/api/lido-minute-nft/mint/status', {address: this.wallet?.address});
                this.mintTx = mintTx?.data?.data;
                this.amountReceived = (this.mintTx.quantity / 1000000).toLocaleString(undefined, {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            } catch (e) {
                if (e?.response?.status !== 404) {
                    console.log({e});
                }
            }
        }
    }
}

window.cardanoWallet = cardanoWallet;

window.globalVideoPlayer = globalVideoPlayer;

// translate proposal
window.translateProposal = function translateProposal() {
    return {
        loggedIn:false,
        model_id: null,
        translate: false,
        editing: false,
        startTranslation: false,
        translatedContent: null,
        focusedOptionIndex: null,
        options: [],
        targetLang: null,
        sourceLang: null,
        proposalContent: null,
        data: {
            content: '',
            sourceLanguage: '',
            targetLanguage: ''
        },
        processing: false,
        translationUpdates:{
            updates:'',
            translationLang:''
        },
        locale:null,
        targetLocale:null,
        save:false,
        init() {
        this.checkLogin();
        this.locale = 'en';
        },
        getTargetLocal(val) {
            this.targetLocale=val
        },
        checkLogin() {
            axios.get('/api/user').then(response => {
            this.loggedIn = true;
            this.getLangOptions()
            }).catch(error => {
            });
        },
        getLangOptions() {
            window.axios.get('/languageOptions/'+ `${this.model_id}`)
                .then((res) => {
                    this.options = res.data
                })
        },
        getContent(content) {
            this.proposalContent = content;
        },
        getModelID(id) {
            this.model_id = id;
        },
        getModelData() {
            this.data.content = this.proposalContent;
            this.data.sourceLanguage = this.locale;
            this.data.targetLanguage = this.targetLang;
            this.translationUpdates.translationLang = this.targetLang;
        },
        getTranslation() {
            this.getModelData();
            this.processing = true;
            this.editing = true;
            window.axios.post('/translate/' + `${this.model_id}`, this.data)
            .then((res) => {
                this.processing = false;
                if (this.responseValidity(res.data)) {
                    this.proposalContent = res.data;
                    this.save = true;
                    } else {
                    this.proposalContent = this.proposalContent;
                    this.save = true;
                    }}
            )
        },
        responseValidity(res){
            if ((res.length/this.proposalContent.length ) >= 0.3)
            {
                return true;
            }
            return false;
        },
        submitEdits() {
            this.editing = false;
            this.translate = false;
            this.save = false;
            this.translationUpdates.updates = this.proposalContent;
            window.axios.patch('/translation/'+ `${this.model_id}`, this.translationUpdates)
            .then((res) => {
                this.proposalContent = res.data;
            });

        }
    };
}

window.globalReactions = function globalReactions(post) {
    return {
        loggedIn: false,
        reactionsCount: {
            "❤️": post.hearts_count,
            "👍": post.thumbs_up_count,
            "🎉": post.party_popper_count,
            "🚀": post.rocket_count,
            "👎": post.thumbs_down_count,
            "👀": post.eyes_count
        },


        async addReaction(reaction, id){
            let data = {
                comment: reaction
            }
            const res = await window.axios.post(`/react/post/${id}`, data);
            this.reactionsCount = {
                "❤️": res.data.hearts_count,
                "👍": res.data.thumbs_up_count,
                "🎉": res.data.party_popper_count,
                "🚀": res.data.rocket_count,
                "👎": res.data.thumbs_down_count,
                "👀": res.data.eyes_count
            };
        },
    }
}

Alpine.magic('tt', el => message => {
    let instance = tippy(el, {content: message, trigger: 'manual'})

    instance.show()

    setTimeout(() => {
        instance.hide()

        setTimeout(() => instance.destroy(), 150)
    }, 2000)
})

// Directive: x-tooltip
Alpine.directive('tt', (el, {expression}) => {
    tippy(el, {content: expression})
})

Alpine.start();

const rellaxElement = document.getElementsByClassName("rellax")
let rellax = [];
if (rellaxElement.length > 0) {
    for (let i = 1; i < rellaxElement.length; i++) {
        rellax[i] = new Rellax('.rellax', {
            horizontal: true,
            vertical: true
        });
    }
}

