import Alpine from "alpinejs";
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Tooltip from "@ryangjchandler/alpine-tooltip";
import persist from '@alpinejs/persist';
import focus from '@alpinejs/focus';
import {cardanoWallet} from "../../../www2/resources/js/lib/utils/cardanoWallet";
import {globalVideoPlayer} from "../../../www2/resources/js/lib/utils/globalVideoPlayer";
import LZString from 'lz-string';
import {difference, filter, flatten, groupBy, includes, map, omit, reject, some, trim, uniq, uniqBy} from "lodash";

window.moment = require('moment');

window['moment-timezone'] = require('moment-timezone');


Alpine.plugin(Clipboard);
Alpine.plugin(Tooltip);
Alpine.plugin(persist);
Alpine.plugin(focus);

Alpine.data('voterTool', function voterTool() {
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
}.bind(Alpine));

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

Alpine.data('catalystReportComments', function globalComments() {
    return {
        showComments: false,
        newComment: '',
        comments: null,

        toggleShowComments(reportId) {
            this.showComments = !this.showComments;
            if (!this.comments) {
                this.loadComments(reportId).then();
            }
        },

        addComment() {
            // Alpine.store('cm').addComment(this.newComment);
        },

        get commentsArray() {
            setTimeout(() => {
                return this.comments;
            }, 1200);
        },
        get commentsAvailable() {
            return (this.comments.length > 0);
        },

        async loadComments(itemId) {
            console.log({itemId});
            if (!!this.comments) {
                return;
            }

            await window.axios.get(`/api/catalyst-explorer/reports/comments/${itemId}`, {})
                .then((res) => {
                    console.log({res});
                    this.comments = [...res.data];
                });
        }

    }
}.bind(Alpine));

Alpine.data('bookmarksMenuLink', function () {
    return {
        getBookmarkCount() {
            return Alpine.store('vt').proposals?.length;
        }
    }
}.bind(Alpine));

Alpine.data('bookmarkButton', function () {
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
}.bind(Alpine));

Alpine.data('cardanoWallet', cardanoWallet.bind(Alpine));
Alpine.data('globalVideoPlayer', globalVideoPlayer.bind(Alpine));

window.Alpine = Alpine;
Alpine.start();
