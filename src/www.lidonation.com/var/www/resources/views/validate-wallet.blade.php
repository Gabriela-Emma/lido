<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $snippets->validateWallet }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex flex-col gap-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(!$user->has_lido_nft)
                <div class="overflow-hidden bg-white shadow-xs sm:rounded-sm">
                    <div class="bg-white shadow-xs sm:rounded-sm">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Thanks for validating your wallet.
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Validating your wallet sends a LIDO Nation nft to your wallet that is used for
                                    authentication and access control.
                                    This validation currently only works for LIDO pool delegates. Do not use if you are
                                    not a delegate.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="overflow-hidden bg-white shadow-xs sm:rounded-sm">
                <x-portal.validate-wallet/>
            </div>
        </div>
    </div>
</x-app-layout>
