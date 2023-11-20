@props([
    'commit',
    'view' => 'detail'
])
<div class="p-5 w-full rounded-sm flex flex-col justify-start bg-white shadow-sm mb-4 relative break-inside-avoid drip">
    <div class="break-long-words break-words">
        <x-markdown>{{$commit->content}}</p></x-markdown>
    </div>

    <div class="mt-16 divide-y divide-teal-300 border-t border-teal-300">
        <div class="flex flex-row gap-4 justify-between items-center py-4">
            <div class="text-teal-800 opacity-50 text-sm">Author</div>
            <div class="text-teal-800 font-medium text-base">
                {{$commit?->author}}
            </div>
        </div>
        <div class="flex flex-row gap-4 justify-between items-center py-4">
            <div class="text-teal-800 opacity-50 text-sm">
                Date
            </div>
            <div class="text-teal-800 font-medium text-base">
                <x-carbon :date="$commit->created_at" human />
            </div>
        </div>

    </div>
</div>
