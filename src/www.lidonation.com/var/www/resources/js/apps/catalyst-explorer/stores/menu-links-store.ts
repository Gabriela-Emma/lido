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
            { name: 'Catalyst Api', url: '/catalyst-explorer/api'}
        ]},
        { title:'Tools', links:[
            { name: 'Voter Tool', route: 'catalyst-explorer.voter-tool', component: 'VoterTool'},
            { name: 'Check my registration', route: 'catalyst-explorer.registrations', component: 'Registrations'},
            { name: 'Check my vote', route: 'catalyst-explorer.registrations', component: 'Registrations'},
            { name: 'My Bookmarks', route: 'catalyst-explorer.myBookmarks', component: 'MyBookmarks'}        
        ]}        
     ]);

     return {
        menulinks, menudrops
     }
});