<div class="inline-flex">
    @if($proposal->type=='challenge')
        <x-catalyst.challenges.drip :challenge="$proposal"/>
    @else
        <x-catalyst.proposals.drip :proposal="$proposal" />
    @endif
</div>
