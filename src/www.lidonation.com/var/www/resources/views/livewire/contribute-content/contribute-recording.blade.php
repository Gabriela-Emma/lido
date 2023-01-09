<x-modal formAction="saveArticle">
    <x-slot name="title">
        <div class="container">
            Record an Article
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="max-h-[80vh] overflow-y-auto" x-data="{
            article: null,
            chooseArticle: function(article) {
                this.article = article;
                Livewire.emit('chooseArticle');
            }
        }">
            <section class="relative">
                @if(!!$this->article && $this->recordingStarted)
                    <div class="">
                        @if($this->recordingComplete)
                            <div class="flex flex-col gap-4 p-6 mb-4 text-white bg-primary-600">
                                <h4 class="text-xl font-extrabold">Reading submitted Successfully!</h4>
                                <p>You should see your recording up within a week.</p>
                                <p>
                                    Thank you for being part of our pool!
                                </p>
                            </div>
                        @else
                            <div class="sticky top-0 mb-4">
                                <x-public.record-article :post="$this->article"/>
                            </div>
                        @endif

                        @if(!$this->recordingComplete)
                            <div class="container">
                                <h2 class="font-medium xl:text-3xl">{{$this->article->title}}</h2>

                                <article class="mb-6 text-xl">
                                    <div class="mt-3">
                                        @if(Lang::has($this->article->getTable() . '.' . $this->article->slug ))
                                            <x-markdown>{{__($this->article->getTable() . '.' . $this->article->slug)}}</x-markdown>
                                        @else
                                            <x-markdown>{{$this->article->content}}</x-markdown>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="flex flex-col gap-6 mb-4">
                    @if(!!$this->article)
                        @if(!$this->recordingStarted)
                            <h2 class="p-6 font-medium text-center">
                                Your about to record <strong>{{$this->article->title}}</strong>
                                <br/><small class="font-semibold">Thanks for helping!</small>
                            </h2>
                        @endif
                    @else
                        <h2 class="p-6 font-medium text-center">
                            Voice recordings make website content accessible to more people.
                            <br/><small class="font-semibold">Thanks for helping!</small>
                        </h2>
                    @endif

                    @if(!!$this->article && !$this->recordingStarted)
                        <div class="flex flex-col gap-4 p-6 bg-gray-50" x-transition>
                            <div class="container xl:pr-40 2xl:pr-96">
                                <h2 class="mb-0">
                                    {{$snippets->someThingsToRemember}}
                                </h2>

                                <div>
                                    <p>
                                        Works best on a laptop or desktop computers or android phone.
                                    </p>

                                    <p class="my-2">
                                        Click record and read the main contents of this article out loud, starting with
                                        the
                                        title.
                                        Speak clearly, at a normal speed. When you are done, click stop, then SEND.
                                    </p>

                                    <p>
                                        We will take it from there!
                                    </p>
                                </div>

                                <div class="mt-4">
                                    <dl class="bg-white rounded-sm shadow-xs max-w-2xl mx-auto sm:gridsm:grid-cols-2">
                                        <div
                                            wire:click="startRecorder"
                                            class="flex flex-col p-6 text-center border-t border-b border-gray-100 group sm:border-0 sm:border-l sm:border-r hover:cursor-pointer">
                                            <div
                                                class="order-1 text-4xl font-extrabold text-teal-600 group-hover:text-yellow-500">
                                                <span>Load</span> <span>Recorder</span>
                                            </div>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!$this->article)
                        <div class="p-6 bg-gray-50" x-transition>
                            <h2>Select an article</h2>

                            <div>
                                <div class="flow-root mt-6">
                                    <ul role="list" class="-my-5 divide-y divide-gray-300">
                                        @foreach($posts as $post)
                                            <li class="py-4">
                                                <div class="flex items-center space-x-4 group">
                                                    <div class="flex flex-col flex-1 min-w-0 gap-2">
                                                        <h3 class="text-base capitalize">
                                                            {{$post->title}}
                                                        </h3>
                                                        <div class="relative flex gap-4 text-sm text-gray-600 -top-3">
                                                            <div>
                                                                {{$post->type_name}}
                                                            </div>
                                                            <div>
                                                                {{read_time($post->content)}}
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="text-sm text-gray-500 line-clamp-2 2xl:line-clamp-3">
                                                            {{Str::words($post->summary)}}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <a href="#"
                                                           wire:click="chooseArticle('{{$post->slug}}')"
                                                           class="inline-flex items-center px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 bg-white rounded-sm border border-gray-300 shadow-xs hover:bg-gray-50 group-hover:bg-pink-600 group-hover:text-white">
                                                            Record
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </x-slot>

    {{--    <x-slot name="buttons">--}}

    {{--        <button type="button"--}}
    {{--                x-transition--}}
    {{--                onclick='Livewire.emit("closeModal", "contribute-content.contribute-article")'--}}
    {{--                class="relative h-10 px-4 py-2 m-0 text-sm font-medium text-white bg-gray-400 border border-transparent rounded-sm shadow-xs top-1 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">--}}
    {{--            Close--}}
    {{--        </button>--}}
    {{--    </x-slot>--}}
</x-modal>
