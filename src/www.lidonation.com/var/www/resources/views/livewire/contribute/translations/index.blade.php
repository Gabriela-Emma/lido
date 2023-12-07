<div class="relative bg-white contribute contribute-translations">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <div class='relative flex flex-row items-end justify-start gap-3 font-black text-teal-600 -bottom-6'>
                <div>
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 48 48"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <span class='font-light'>{{__('Contribute') }}</span> <span>{{__('Translation') }}</span>
                </div>
            </div>
        </x-slot>
        @isset($this->translatingTo)
            <p class="mt-1">
                translating to {{$this->translatingTo}}</span>
            </p>
        @endisset
    </x-public.page-header>
    <section>
            <div class="flex flex-row items-center gap-8 px-10">
                <button wire:click="toggleFilter('all')" class="{{ $filter === 'all' ? 'bg-teal-10 py-1 px-4 rounded-lg' : 'font-medium text-gray-700' }}">
                    All
                </button>
                <button wire:click="toggleFilter('completed')" class="{{ $completed ? 'bg-teal-10 py-1 px-4 rounded-lg' : 'font-medium text-gray-700' }}">
                    Completed
                </button>
                
                <button wire:click="toggleFilter('inProgress')" class="{{ $inProgress ? 'bg-teal-10 py-1 px-4 rounded-lg' : 'font-medium text-gray-700' }}">
                    In Progress
                </button>
                
                <button wire:click="toggleFilter('onlyMine')" class="{{ $onlyMine ? 'bg-teal-10 py-1 px-4 rounded-lg' : 'font-medium text-gray-700' }}">
                    Only Mine
                </button>
            </div>
    </section>
    <section>
        <div class="bg-white p-10 rounded-md shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="p-6 bg-teal-500 text-left font-semibold text-white">
                            ID
                        </th>
                        <th class="p-6 bg-teal-500 text-left font-semibold text-white">
                            Title
                        </th>
                        <th class="p-6 bg-teal-500 text-left font-semibold text-white">
                            Status
                        </th>
                        <th class="p-6 bg-teal-500"></th>
                    </tr>
                </thead>
                <tbody class="bg-teal-10 divide-y divide-gray-200">
                    @foreach($translations as $index => $translation)
                        <tr class="{{ $index % 2 === 0 ? 'bg-primary-20' : 'bg-primary-10' }}">
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $index }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $translation->title }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $translation->status }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    @if ($translation->status !== 'committed')
                                        <a wire:navigate wire:click="commitToTranslation({{ $translation->id }})"
                                            href="{{route('contribute.translations.edit', ['translation' => $translation->id])}}"
                                                class="bg-teal-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Commit
                                        </a>
                                    @else
                                        <span class="text-gray-500">Committed</span>
                                    @endif
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
