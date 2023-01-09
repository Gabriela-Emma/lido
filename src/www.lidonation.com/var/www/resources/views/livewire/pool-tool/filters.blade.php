<div class="flex flex-row items-center justify-between gap-2">
    <div class="h-16 flex items-center">
        @if($this->searchableColumns()->count())
            <div class="w-96 flex h-full rounded-sm shadow-sm">
                <div class="relative flex-grow  h-full focus-within:z-10">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor"
                             fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input wire:model.debounce.500ms="search"
                           class="form-input block bg-white focus:bg-white w-full h-full rounded-sm pl-10 transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                           placeholder="{{__('Search in')}} {{ $this->searchableColumns()->map->label->join(', ') }}"/>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button wire:click="$set('search', null)"
                                class="text-gray-300 hover:text-red-600 focus:outline-none">
                            <x-icons.x-circle class="h-5 w-5 stroke-current"/>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="flex-1 flex justify-end">
        @foreach($this->columns as $index => $column)
            <div class="table-cell overflow-hidden align-top">
                @isset($column['filterable'])
                    @if( is_iterable($column['filterable']) )
                        <div :wire:key="$index">
                            @include('datatables::filters.select', ['index' => $index, 'name' => $column['label'], 'options' => $column['filterable']])
                        </div>
                    @else
                        <div :wire:key="$index">
                            @include('datatables::filters.' . ($column['filterView'] ?? $column['type']), ['index' => $index, 'name' => $column['label']])
                        </div>
                    @endif
                @endisset
            </div>

        @endforeach
    </div>
    <div class="w-9 mb-auto">
        <x-icons.cog wire:loading class="h-9 w-9 animate-spin text-gray-400"/>
    </div>
</div>
