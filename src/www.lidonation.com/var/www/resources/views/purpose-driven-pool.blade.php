<x-public-layout class="pool-purpose" :metaTitle="$post->title">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class='font-thin'>
                {{ __('Purpose') }}
            </span>
            <span class='font-extrabold text-teal-600'>
                {{ __('Driven') }}
            </span>
        </x-slot>

        <h2>Vote for causes you care about.</h2>
        <p>
            We are currently in Phase 1/ Round 1 of our giving program.
        </p>

        <p>
            Voting is open through the end of the year, and the first winner will be announced Jan 1 2022.
            >>Learn more about our roadmap & future phases<<
        </p>
    </x-public.page-header>

    <section class="py-12 text-white bg-teal-600">
        <div class="container">
            <h2>
                Voting is open to all LidoNation delegators.
            </h2>
            @auth()
                <p>
                    You are logged in as
                    <strong class="font-extrabold">{{$user}}</strong>.
                    <span>You have <strong class="font-extrabold">{{$user?->phuffycoin_balance ?? 0}}</strong> phuffy available.</span>
                </p>
            @endauth
            @guest()
                <a href="{{localizeRoute('login')}}"
                   class="inline-flex items-center menu-link group">
                    <span
                        class="inline-flex items-center px-2.5 py-2 font-semibold text-white rounded-sm border border-transparent shadow-xs bg-accent-700 group-hover:bg-accent-600 group-focus:outline-none group-focus:ring-2 group-focus:ring-offset-2 group-focus:ring-accent-500">
                        <span class="px-1">
                            {{ $snippets->delegatorLogin}}
                        </span>
                    </span>
                </a>
            @endguest
        </div>
    </section>

    @if($causes->isNotEmpty())
        <section class="relative bg-white">
            <div class="container">
                <h2 class="pt-12 text-3xl font-semibold text-gray-900">
                    Current Campaign
                    <hr class="mb-0"/>
                </h2>

                <div class="flex flex-col gap-0 divide-y">
                    @foreach($causes as $cause)
                        <x-causes.drip :cause="$cause" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($causes->isEmpty())
        <section class="relative py-12">
            <div class="container">
                <div class="bg-white border border-gray-100 shadow-sm">
                    <div class="px-4 py-16 mx-auto max-w-2xl text-center sm:py-20 sm:px-6 lg:px-8">
                        <h2 class="text-3xl font-extrabold text-black sm:text-4xl">
                            <span class="block">
                                Queueing the next campaign
                            </span>
                            {{--                            <span class="block">Start using Workflow today.</span>--}}
                        </h2>
                        <p class="mt-4 text-lg leading-6 text-gray-500">
                            check back soon
                        </p>
                        {{--                        <a href="#" class="inline-flex justify-center items-center px-5 py-3 mt-8 w-full text-base font-medium text-indigo-600 bg-white rounded-md border border-transparent hover:bg-indigo-50 sm:w-auto">--}}
                        {{--                            Sign up for free--}}
                        {{--                        </a>--}}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="py-12 bg-gray-50 border border-gray-100">
        <div class="container">
            <h2 class="mb-4 text-3xl font-semibold text-gray-900">
                Comments
            </h2>

            <!-- Comments -->
            @if($post && $post->comments->isNotEmpty())
                <div class="">
                    <x-public.divider></x-public.divider>
                </div>

                <div class="py-16 pt-8 max-w-5xl">
                    <x-public.comments :model="$post"></x-public.comments>
                </div>
        @endif

        <!-- Comment Form -->
            <div class="">
                <x-public.divider></x-public.divider>
            </div>
            <div class="py-16 max-w-5xl">
                <livewire:comment-form-component
                    :modelId="$post->id"
                    :modelType="$post->type ?? 'App\Models\Post'"
                    :prompt="$post->comments->count() > 1 ? $post->comment_prompt : null"/>
            </div>
        </div>
    </section>

</x-public-layout>
