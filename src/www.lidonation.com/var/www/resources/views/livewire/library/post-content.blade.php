<div class="" x-data="translateProposal({{ $post->id }}, '{{ $pageLocale }}','{{class_basename($post->type)}}')">
    <div class="h-full overflow-clip p-4 break-normal">
        <div class="flex flex-col items-center">
            <article class="mb-6 text-xl text-justify">
                <div class="mt-3">
                    <x-markdown>{{$post->content}}</x-markdown>
                </div>
            </article>
        </div>
    </div>
</div>
