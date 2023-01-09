@props([
    'proposal',
    'embedded' => false
])
<div class="space-x-1 italic">
    @if($proposal->status == 'complete')
        <span
            class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-pink-400">completed</span>
    @elseif(!!$proposal->funded_at)
        <span
            class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-teal-light-500">funded</span>
    @elseif($proposal->funding_status == 'pending')
        <span
            class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-gray-600">vote pending</span>
    @else
        <span
            class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm {{$proposal->funding_status == 'over_budget' ? 'bg-slate-400' : 'bg-slate-300'}}">
            {{Str::replace('_', ' ', $proposal->funding_status)}}
        </span>
    @endif

    @if($proposal->is_impact_proposal)
    <span
        class="inline-block px-1.5 py-0.5 font-semibold text-gray-800 text-xs rounded-sm bg-accent-500">
        impact proposal
    </span>
    @endif

    <span>{{$proposal->funded_at ? 'Awarded' : 'Requested'}} {{round((float)($proposal->amount_requested / $proposal->fund->amount) * 100, 3 ) . '%'}} of the
    fund.</span>
</div>
