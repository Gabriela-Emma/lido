<div wire:init="loadStats" class="overflow-hidden">
    <x-proposals.stats
        :totalProposals="$totalProposals"
        :fundedProposalsCount="$fundedProposalsCount"></x-proposals.stats>
</div>
