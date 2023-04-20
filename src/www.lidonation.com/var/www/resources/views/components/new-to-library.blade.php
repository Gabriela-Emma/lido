@props([
   'bgColor'=> 'bg-eggplant-500',
   'newToLibrary',
   'latestLidoMinute'
])
   @if($newToLibrary)
    <section class="py-16 relative bg-primary-10 relative" id="new-to-library">
        <div class="container">
            <h2 class="text-5xl text-gray-900 decorate dark mb-6">
               <span class="">
                   {{$snippets->newToThe}}
               </span>
                <span class="text-teal-600 opacity-90">
                  {{$snippets->library}}
               </span>
            </h2>
        </div>
        <div class="container">
            <div class="flex flex-nowrap gap-8 overflow-x-auto posts">
                @if($latestLidoMinute)
                    <div class="flex flex-col shrink-0 snap-center w-[380px] lg:w-[420px] xl:w-[480px] 2xl:w-[540px]">
                            <?php $post = $latestLidoMinute; ?>
                        @include("podcast.drip")
                    </div>
                @endif
                <div class="flex-1 flex flex-col">
                    <div
                        class="flex flex-row flex-nowrap xl:gridxl:grid-cols-22xl:grid-cols-3 gap-6 posts">
                        @foreach($newToLibrary as $post)
                            <div
                                class="w-[380px] xl:w[420px] 2xl:w-[420px] md:border-r md:border-gray-300 px-5 -mt-px -ml-px post">
                                    <?php $showHero = true; ?>
                                @include("post.drip")
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif