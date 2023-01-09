@props([
    'mintTxs'
])
@isset($mintTxs)
<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-sm">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                User
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Score
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Percent
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Amount
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Delegation
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($mintTxs as $tx)
            <tr wire:key="{{$tx->id}}">
                <!-- User -->
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{$tx->user?->name}}
                </td>
                <!-- Score -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{$tx->score}}
                </td>
                <!-- Percent -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{$tx->distribution_percent}}
                </td>
                <!-- Amount -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{$tx->amount_formatted}} Phuffies
                </td>
                <!-- Epoch Delegation -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{$tx->epoch_delegation_amount_formatted ?? '-'}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endisset
