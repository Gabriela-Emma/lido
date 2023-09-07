<div>
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

    <section class="relative py-8 bg-white">
        <div class="container">
            @can('translate articles')
                <div class="flex flex-col justify-center py-4 mb-4 border-t-4 bg-gray-50 sm:px-6 lg:px-8 translations-wrapper">
                    <livewire:translations.translations-component />
                </div>
            @else
                <div class="flex flex-col justify-center py-4 mb-4 bg-info sm:px-6 lg:px-8">
                    <p>
                        Your account still need to be set up for translation.
                    </p>
                </div>
            @endcan
        </div>
    </section>
</div>
