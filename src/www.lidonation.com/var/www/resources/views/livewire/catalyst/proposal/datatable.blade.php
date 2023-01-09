<div class="relative z-10">
    @if($beforePageSlot)
        @include($beforePageSlot)
    @endif

    <section class="relative">
        <div class="container">
            <nav class="flex space-x-1" aria-label="Tabs">
                <a href="{{localizeRoute('cardano-treasury')}}"
                   class="px-4 py-2 mb-1 text-xl font-medium text-white rounded-sm bg-teal-600 hover:text-yellow-500"
                   aria-current="page">
                   {{$snippets->treasuryDashboard}}
                </a>

                <div
                    class="px-4 py-2 text-xl font-medium rounded-t-sm bg-teal-600 text-accent-500">
                    {{$snippets->catalystExplorer}}
                </div>
            </nav>
        </div>
    </section>

    <section class="py-8 text-white bg-teal-600 text-md">
        <div class="container">
            <div class="flex flex-row gap-4 items-center">
                <livewire:project-catalyst-stats />
            </div>
        </div>
    </section>

    <section class="relative py-8 bg-white">
        <div class="container">
            <div class="grid grid-cols-8 gap-4">
                <div class="col-span-8 md:col-span-3 lg:col-span-2">
                    @if($beforeTableSlot)
                        <div class="sticky top-4">
                            @include($beforeTableSlot)
                        </div>
                    @endif
                </div>
                <div class="relative col-span-8 md:col-span-5 lg:col-span-6">
                    <div class="bg-white max-w-screen">
                        <div class="">
                            <ul class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                @forelse($this->results as $result)
                                    <li class="col-span-1 flex flex-col border bg-white {{ !!$result->funded_at ? 'border-primary-500' : ''}} rounded-sm divide-y {{ !!$result->funded_at ? 'divide-primary-200' : 'divide-gray-300'}} ">
                                        @foreach($this->columns as $column)
                                            @if(!$column['hidden'])
                                                {!! $result->{$column['name']} !!}
                                            @endif
                                        @endforeach
                                    </li>
                                @empty
                                    <li>
                                        <p class="p-3 text-lg text-teal-600">
                                            {{ __("There's Nothing to show at the moment") }}
                                        </p>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        @unless($this->hidePagination)
                            <div class="py-4 bg-white rounded-sm rounded-t-none border-b border-gray-300 max-w-screen">
                                <div class="justify-between items-center p-2 sm:flex">
                                    {{-- check if there is any data --}}
                                    @if(count($this->results))
                                        <div class="flex items-center my-2 sm:my-0">
                                            <select name="perPage"
                                                    class="block py-2 pr-10 pl-3 mt-1 w-full text-base leading-6 border-gray-300 form-select focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                                                    wire:model="perPage">
                                                @foreach(config('livewire-datatables.per_page_options', [ 10, 25, 50, 100 ]) as $per_page_option)
                                                    <option
                                                        value="{{ $per_page_option }}">{{ $per_page_option }}</option>
                                                @endforeach
                                                <option value="99999999">{{__('All')}}</option>
                                            </select>
                                        </div>

                                        <div class="my-4 sm:my-0">
                                            <div class="lg:hidden">
                                            <span
                                                class="space-x-2">{{ $this->results->links('datatables::tailwind-simple-pagination') }}</span>
                                            </div>

                                            <div class="hidden justify-center lg:flex">
                                                <span>{{ $this->results->links('datatables::tailwind-pagination') }}</span>
                                            </div>
                                        </div>

                                        <div class="flex justify-end text-gray-600">
                                            {{__('Results')}} {{ $this->results->firstItem() }}
                                            - {{ $this->results->lastItem() }} {{__('of')}}
                                            {{ $this->results->total() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if($afterTableSlot)
                    <div class="mt-8">
                        @include($afterTableSlot)
                    </div>
                @endif
            </div>
        </div>
    </section>

</div>
