@if($proposals->isNotEmpty())
    <div class="flex flex-row flex-wrap gap-3 w-full">
        @foreach($proposals as $proposal)
            <div class="inline-flex flex-0">
                @if($proposal->type=='challenge')
                    <x-catalyst.challenges.drip :challenge="$proposal" />
                @else
                    <x-catalyst.proposals.drip :proposal="$proposal" />
                @endif
            </div>
        @endforeach
    </div>
@endif
