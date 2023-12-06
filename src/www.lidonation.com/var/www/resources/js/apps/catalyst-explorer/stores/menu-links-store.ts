import {defineStore} from "pinia";
import {ref} from "vue";

export const menulinkStore = defineStore('menulinks', () => {
     const menulinks = ref([
        { name: 'Home', route: 'catalyst-explorer.home'},
        { name: 'Proposals', route: 'catalyst-explorer.proposals'},
        { name: 'People', route: 'catalyst-explorer.people.index'},
        { name: 'Charts', route: 'catalyst-explorer.charts'},
        { name: 'Voter Tool', route: 'catalyst-explorer.voter-tool'}
     ]);

     const menudrops = ref([
        { title:'Proposals', links:[
            { name: 'All Proposals', route: 'catalyst-explorer.proposals', component: 'Proposals'},
            { name: 'Proposal Reviews', route: 'catalyst-explorer.assessments', component: 'Assessments'},
            { name: 'Monthly Reports', route: 'catalyst-explorer.reports', component: 'Reports'},
            { name: 'Funds', route: 'catalyst-explorer.funds.index', component: 'Funds'}
        ]},
        { title:'People', links:[
            { name: 'Proposers', route: 'catalyst-explorer.people.index', component: 'People'},
            { name: 'Groups', route: 'catalyst-explorer.groups', component: 'Groups'},
            { name: 'dReps', route: 'catalyst-explorer.dReps.index', component: 'DReps'}
        ]},
        { title:'Data', links:[
            { name: 'Catalyst by the Numbers', route: 'catalyst-explorer.charts', component: 'Charts'},
            { name: 'CCV4 Votes', route: 'projectCatalyst.votes.ccv4'},
            { name: 'Catalyst Api', url: '/catalyst-explorer/api'},
            { name: 'Proposals CSV', url: 'https://ncdb.lidonation.com/dashboard/#/nc/view/26a2a22e-c722-445d-bbad-3ca6009fb890'}
        ]},
        { title:'Tools', links:[
            { name: 'Voter Tool', route: 'catalyst-explorer.voter-tool', component: 'VoterTool'},
            { name: 'Check my registration', route: 'catalyst-explorer.registrations', component: 'Registrations'},
            { name: 'Check my vote', route: 'catalyst-explorer.my-votes', component: 'CheckMyVotes'},
            { name: 'My Bookmarks', route: 'catalyst-explorer.myBookmarks', component: 'MyBookmarks'},
            { name: 'My Draft Ballots', route: 'catalyst-explorer.myDraftBallots', component: 'MyDraftBallots'}
        ]}
     ]);

     return {
        menulinks, menudrops
     }
});
