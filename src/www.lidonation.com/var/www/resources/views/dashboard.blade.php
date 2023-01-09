<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $snippets->portal }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex grid flex-col grid-cols-2 gap-6 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="col-span-2 overflow-hidden bg-white rounded-sm shadow-xs">
                <x-portal.welcome />
            </div>

            <div class="grid grid-cols-5 col-span-2 gap-6 text-sm">
                <div class="col-span-2">
                    @if($user?->hasRole(\App\Enums\RoleEnum::super_admin()->value))
                        <div class="overflow-hidden text-white shadow-xs bg-accent-700 sm:rounded-sm">
                            <div class="px-4 py-5 sm:p-6">
                                <h2 class="font-semibold leading-6">
                                    Mint Phuffies
                                </h2>
                                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                                    <div class="max-w-xl">
                                        <p>Start the mint process for an epoch.</p>
                                    </div>
                                    <div class="mt-5 sm:mt-0 sm:flex-shrink-0 sm:flex sm:items-center">
                                        <a href="{{route('mint')}}"
                                           type="button"
                                           class="inline-flex items-center px-4 py-2 font-medium bg-white border border-transparent rounded-sm shadow-sm text-accent-800 hover:text-yellow-900 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            New Mint
                                        </a>
                                    </div>
                                </div>
                                <div class="max-h-[32rem] overflow-y-auto">
                                    <x-portal.mints :mints="$mints"/>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-span-3">
                    <div class="overflow-hidden bg-white rounded-sm shadow-xs">
                        <div class="px-6 py-3">
                            <h2 class="flex flex-row items-center gap-1 p-0 mb-0 text-gray-600">
                                <span>Running Campaign</span>
                                <span class="flex items-center text-xs text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 w-4 h-4 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <span>
                                        Closing
                                        <time datetime="2020-01-07">April 1, 2022</time>
                                    </span>
                                </span>
                            </h2>
                            <hr class="mb-0 border-t border-b-0 border-gray-300 border-opacity-50"/>
                        </div>
                        <div>

                        </div>
                        <div>
                            <x-portal.causes />
                        </div>
                    </div>
                </div>
            </div>


            {{--            <div class="overflow-hidden bg-white shadow-xs sm:rounded-sm">--}}
            {{--                <x-portal.vote />--}}
            {{--            </div>--}}
        </div>
    </div>
</x-app-layout>
