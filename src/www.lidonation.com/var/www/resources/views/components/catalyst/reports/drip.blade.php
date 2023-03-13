@props([
    'report',
    'view' => 'detail'
])
<div x-data="singleProposalReportComments" class="p-5 w-full bg-white rounded-sm relative flex flex-col justify-start bg-white shadow-sm mb-4 relative break-inside-avoid drip">
    <div class="break-long-words break-words">
        <x-markdown>{{$report->content}}</p></x-markdown>
    </div>

    <div class="mt-16 divide-y divide-teal-300 border-t border-teal-300 specs">
        <div class="py-4 border-t border-teal-300">
            <ul x-show="loggedIn" class="flex flex-row gap-3 justify-end">
                <template x-for="(reaction, index) in reactions">
                        <li class="border flex flex-row gap-1 border-slate-600 hover:border-green-500 p-1 rounded-sm text-xs cursor-pointer">
                            <button  @click.prevent="addReaction(reaction, {{$report->id}})" x-text="reaction"></button>
                            <span x-text="getReactionCount(reaction)"></span>
                        </li>
                </template>
            </ul>
        </div>
        
        <div class="flex flex-row gap-4 justify-between items-center py-4 spec-amount-received">
            <div class="text-teal-800 opacity-50 text-sm">Disbursed to Date</div>
            <div class="text-teal-800 font-bold text-base">
                {{$report?->proposal?->formatted_amount_received}}
            </div>
        </div>

        <div class="flex flex-row gap-4 justify-between items-center py-4 spec-title">
            <div class="text-teal-800 opacity-50 text-sm">Proposal</div>
            <a class="text-teal-800 font-medium inline-flex text-base hover:text-yellow-500" target="_blank" href="{{$report?->proposal?->link}}">
                {{$report?->proposal?->title}}
            </a>
        </div>
        <div class="flex flex-row gap-4 justify-between items-center py-4">
            <div class="text-teal-800 opacity-50 text-sm">Status</div>
            <div class="text-teal-800 font-medium text-base">
                {{$report->project_status ?? '-'}}
            </div>
        </div>
        <div class="flex flex-row gap-4 justify-between items-center py-4">
            <div class="text-teal-800 opacity-50 text-sm">
                Completion Target
            </div>
            <div class="text-teal-800 font-medium text-base">
                {{$report->completion_target ?? '-'}}
            </div>
        </div>
        @if($report->attachments->isNotEmpty())
            <div class="flex flex-row gap-4 justify-between items-center py-4">
                <div class="text-teal-800 opacity-50 text-sm">Attachment(s)</div>
                <div class="text-teal-800 font-medium text-right text-base">
                    @foreach($report->attachments as $attachment)
                        <a target="_blank" class="font-medium hover:text-yellow-500 px-1 py-0.5 border border-teal-600 rounded-sm text-xs inline-flex flex-row flex-nowrap gap-2 hover:bg-teal-600" href="{{$attachment}}">
                            <span class="inline-flex">Evidence {{$loop->iteration}}</span>
                            <span class="inline-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

   <div class="w-full mx-auto bg-slate-100 px-4">
       <div class="flex justify-between items-center py-4">
           <div class="text-teal-800 opacity-75 text-sm inline-flex gap-2 items-center h-full">
               <span class="bold text-xl">Comments</span>
               <span>{{$report->comments_count}}</span>
           </div>

           <button id="message-type" name="message-type"
                   x-on:click="toggleShowComments({{$report->id}})" x-html="showComments ? '-' :'+' "
                   class="text-2xl font-medium text-teal-800 hover:text-yellow-600">
           </button>
       </div>

       <div x-cloak x-show="showComments" class="pb-4">
           <template x-if="comments">
            <ul x-if="comments" class="divide-y divide-slate-100">
                <template x-for="(comment, index) in comments" x-cloak class="boarder-b-2 ">
                    <li x-show="comment.text != ''" 
                    class="relative bg-white py-5 px-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 hover:bg-gray-50">
                         <div class="flex flex-row justify-between items-center space-x-3 text-gray-600 font-medium text-sm">
                             <div>
                                 <p class="truncate" x-text="comment.commentator?.name">
                                 </p>
                             </div>
                             <span x-text="timeAgo(comment.created_at)"></span>
                         </div>
                         <div class="mt-1">
                             <p class="text-md text-gray-700" x-html="comment.text"></p>
                         </div>
                    </li>
                </template>
            </ul> 
           </template>
           <template x-cloak class="pt-4" x-if="!comments?.length && loggedIn">
                <p>Be the first to leave a comment!</p>
           </template>

           <template x-cloak class="pt-4" x-if="comments?.length && loggedIn">
                <span class="text-xs font-bold relative top-1">Leave a Comment.</span>
           </template>
           <form class="pt-2"
           @submit.prevent="addComment"
           x-show="loggedIn && ! loading"
           >
               {{-- <div class="mb-2">
                   <label for="name" class="block text-sm font-medium text-slate-600">Name </label>
                   <div class="mt-1">
                       <input  id="name" name="name" type="text" autocomplete="name" required
                               class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                   </div>
               </div>

               <div class="mb-2">
                   <label for="email" class="block text-sm font-medium text-slate-600">Email </label>
                   <div class="mt-1">
                       <input  id="email" name="email" type="email" autocomplete="email" required
                               class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                   </div>
               </div> --}}

               <textarea class="border-slate-200 mt-0" name="comment" type="text" row="3" placeholder="Give feedback or ask team a question." required
                         x-model="newComment"></textarea>

               <input type="hidden" name="report" value="{{$report->id}}">

               <button type="submit" class="text-white text-xs px-2 bg-teal-300 hover:bg-teal-800 ml-auto">
                Post
               </button>
           </form>

           <template x-if="loading" class="mt-4">
            <x-theme.spinner square="8" squareXl="8" theme="green"/>
           </template>

           <template x-if="commentPosted">
                <div class="rounded-sm bg-teal-100 p-4 mt-3">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">Successfully Submitted</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <input type="checkbox" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50" checked>
                                </input>
                            </div>
                        </div>
                    </div>
                </div>
           </template>

            <div x-cloak x-show="!loggedIn" class="space-y-2 bg-white/50 p-2 mt-2 text-center">
                <p>
                    Login or Register to leave a comment!
                </p>
                <div class="flex gap-3 justify-center items-center">
                    <a href="/catalyst-explorer/login" class="font-bold text-teal-600 hover:text-teal-500">
                        Sign in
                    </a>
                    <a href="/catalyst-explorer/register"
                        class="font-bold text-teal-600 hover:text-teal-500">
                        Register
                    </a>
                </div>
           </div>

       </div>
   </div>
</div>


<script>
    function singleProposalReportComments (){
        return {
            showComments: false,
            loading: false,
            newComment: '',
            comments: null,
            loggedIn: false,
            commentPosted: false,
            reactions: ["❤️", "👍", "🎉", "🚀", "👎", "👀"],
            reactionCount: [],

            toggleShowComments(reportId) {
                this.showComments = !this.showComments;
                this.checkLogin();
                if (!this.comments) {
                    this.loadComments(reportId).then();
                    this.showReactions(reportId).then();
                }
            },

            init() {
            this.checkLogin();
            },

            checkLogin() {
                axios.get('/api/user').then(response => {
                this.loggedIn = true;
                }).catch(error => {
                });
            },

            async addReaction(reaction, id){
                let data = {
                    comment: reaction
                }
                const res = await window.axios.post(`/api/catalyst-explorer/reports/comments/${id}/reactions`, data);
                this.showReactions(id).then();
            },


            async addComment(event) {
                //  Alpine.store('cm').addComment(this.newComment);
                this.loading = true;
                const formData = Object.fromEntries(new FormData(event.target));
                const res = await window.axios.post(`/api/catalyst-explorer/reports/comments/${formData.report}`, formData);
                if (res.status === 200 || res.status === 201) {
                    this.commentPosted = true;
                    this.newComment = '';
                    this.loading = false;
                    this.loadComments(formData.report);
                    setTimeout(() => {
                    this.commentPosted = false;
                    }, 2000);
                }
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

                await window.axios.get(`/api/catalyst-explorer/reports/comments/${itemId}`, {})
                    .then((res) => {
                        this.comments = [...res.data];
                    });
            },

            async showReactions(itemId) {

            await window.axios.get(`/api/catalyst-explorer/reports/comments/${itemId}/reactions`, {})
                .then((res) => {
                    this.reactionCount = res.data;
                });
            },

            getReactionCount(reaction) {
                return (this.reactionCount.find(item => item.reaction === reaction)?.count) || 0;
            },

            timeAgo (timestamp) {
                const now = Date.now();
                const createdAt = new Date(timestamp);
                const secondsAgo = Math.floor((now - createdAt) / 1000);
                const minutesAgo = Math.floor(secondsAgo / 60);
                const hoursAgo = Math.floor(minutesAgo / 60);
                const daysAgo = Math.floor(hoursAgo / 24);
        
                if (daysAgo > 0) {
                    return `${daysAgo} day${daysAgo > 1 ? 's' : ''} ago`;
                } else if (hoursAgo > 0) {
                    return `${hoursAgo} hour${hoursAgo > 1 ? 's' : ''} ago`;
                } else if (minutesAgo > 0) {
                    return `${minutesAgo} minute${minutesAgo > 1 ? 's' : ''} ago`;
                } else {
                    return `${secondsAgo} second${secondsAgo > 1 ? 's' : ''} ago`;
                }
            }


        }
    }
</script>
