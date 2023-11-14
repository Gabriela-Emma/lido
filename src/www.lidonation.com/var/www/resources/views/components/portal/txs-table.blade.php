@props([
    'txs',
    'phuffyTxs'
])
<table class="min-w-full overflow-auto divide-y divide-gray-200">
    <tbody
        class="flex flex-col justify-between min-w-full divide-y divide-gray-300 h-52">

    @forelse($txs as $tx)
        @if($phuffyTxs)
            <tr class="flex flex-row text-left text-yellow-500">
                <td class="px-6 py-4 text-sm font-medium whitespace44-nowrap w-28">
                    @if($tx?->date)
                        <x-carbon :date="$tx?->date" format="m/d H:i"/>
                    @else
                        <span>{{$tx?->date ?? '-'}}</span>
                    @endif
                </td>
                <td class="w-32 px-6 py-4 text-sm whitespace44-nowrap">
                    <span class="font-semibold">{{$tx->quantityFormatted}}</span>
                    <span>PHUFFY</span>
                </td>
                <td class="px-6 py-4 text-sm truncate whitespace44-nowrap">
                    <span class="font-semibold">
                        {{$tx?->metadata?->memo ?? "Slot: $tx?->slotNo" ?? '-'}}
                    </span>
                    {{-- <span>ADA</span>--}}
                </td>
            </tr>
        @elseif($tx->type === 'reward')
            <tr class="flex flex-row text-left">
                <td class="px-6 py-4 text-sm font-medium whitespace44-nowrap w-28">
                    @if($tx?->date)
                        <x-carbon :date="$tx?->date" format="m/d H:i"/>
                    @else
                        <span>{{$tx?->date ?? '-'}}</span>
                    @endif
                </td>
                <td class="w-32 px-6 py-4 text-sm whitespace44-nowrap">
                    <span
                        class="font-semibold">{{humanNumber($tx?->amount / 1000000, 2)}}</span>
                    <span>ADA</span>
                </td>
                <td class="px-6 py-4 text-sm truncate whitespace44-nowrap">
                    <span class="">Epoch: </span>
                    <span>
                        {{$tx?->receivedInEpochNo ?? '-'}}
                    </span>
                </td>
            </tr>
        @else
            <tr class="flex flex-row text-left">
                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap w-28">
                    @if($tx?->date)
                        <x-carbon :date="$tx?->date" format="m/d H:i" />
                    @else
                        <span>{{$tx?->date ?? '-'}}</span>
                    @endif
                </td>
                <td class="w-32 px-6 py-4 text-sm whitespace44-nowrap">
                    <span
                        class="font-semibold">{{humanNumber($tx?->quantity / 1000000, 2)}}</span>
                    <span>ADA</span>
                </td>
                <td class="px-6 py-4 text-sm truncate whitespace44-nowrap">
                    <span class="">Block: </span>
                    <span>
                        {{$tx?->blockNo ?? '-'}}
                    </span>
                </td>
            </tr>
        @endif
    @empty
        <tr class="flex flex-row text-left">
            <td class="px-6 py-4 text-sm font-medium whitespace44-nowrap">
                No transactions yet.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
