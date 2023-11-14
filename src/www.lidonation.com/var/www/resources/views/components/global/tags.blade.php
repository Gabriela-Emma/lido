@props([
   'bgColor'=> 'bg-eggplant-500',
   'tags'
])
@if($tags && !empty($tags))
    <section class="py-16 {{ $bgColor }} relative">
        <div class="container">
            <h2 class="mb-4 text-2xl font-extrabold xl:text-4xl 2xl:text-6xl text-slate-50">
                Browse by Tag
            </h2>

            <div>
                <div class="flex flex-row flex-wrap justify-start gap-6">
                    @foreach($tags as $tag)
                        <div class="bg-white rounded-md flex flex-auto">
                            <div class="flex flex-row w-full items-center justify-between p-4">
                                <a href="{{$tag->url}}" class="font-medium text-slate-700">
                                    {{$tag->title}}
                                </a>
                                <div class="bg-slate-100 rounded-sm ml-5">
                                    <div class="bg-slate-300 py-3 px-4 rounded-sm aspect-square font-semibold">
                                        {{$tag->posts_count}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
