<table class="min-w-full divide-y divide-primary-800">
    <thead>
    <tr class="sticky top-0  bg-gradient-to-br from-primary-10 to-primary-20 via-slate-50">
        <th scope="col"
            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">
            Time
        </th>
        <th scope="col"
            class="py-3.5 px-3 text-left text-sm font-semibold text-slate-900">
            Block
        </th>
        <th scope="col"
            class="py-3.5 px-3 text-left text-sm font-semibold text-slate-900">
            Epoch
        </th>
        <th scope="col"
            class="py-3.5 px-3 text-left text-sm font-semibold text-slate-900">
            Slot
        </th>
        <th scope="col"
            class="py-3.5 px-3 text-left text-sm font-semibold text-slate-900">
            Txs
        </th>
        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 md:pr-0">
            <span class="sr-only">Explore</span>
        </th>
    </tr>
    </thead>
    <tbody class="divide-y divide-teal-800">
    <template x-for="block in poolBlocks">
        <tr :class="{
            'text-teal-800': !block.hash,
            'text-slate-600': !!block.hash,
        }">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium  sm:pl-6 md:pl-0">
                <span x-text="block.date"></span>
            </td>
            <td class="whitespace-nowrap py-4 px-3 text-sm text-slate-600">
                <span class="truncate w-16 inline-block text-right " x-text="block.hash"></span>
            </td>
            <td class="whitespace-nowrap py-4 px-3 text-sm">
                <span x-text="block.epoch"></span>
            </td>
            <td class="whitespace-nowrap py-4 px-3 text-sm">
                <span x-text="block.slot"></span>
            </td>
            <td class="whitespace-nowrap py-4 px-3 text-sm">
                <span x-text="block.tx_count"></span>
            </td>
            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                <span x-show="!block.hash">UPCOMING</span>
                <a :href="`${config?.blockExplorer}/block/${block.hash}`" x-show="block.hash"
                   target="_blank" class="text-teal-700 hover:text-teal-900">Explore<span
                        class="sr-only">, on block explorer</span></a>
            </td>
        </tr>
    </template>
    </tbody>
</table>
