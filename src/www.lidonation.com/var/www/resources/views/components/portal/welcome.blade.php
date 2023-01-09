<div class="overflow-hidden bg-white rounded-sm shadow-xs">
    <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
    <div class="p-6 bg-white">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div class="sm:flex sm:space-x-5">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
                <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                    <p class="text-sm font-medium text-gray-600">Welcome,</p>
                    <p class="text-xl font-bold text-gray-900 sm:text-2xl">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-sm font-medium text-gray-600">
                        {{ Auth::user()->roles->implode('name', ', ') }}
                    </p>
                </div>
            </div>
            <div class="flex justify-center mt-5 sm:mt-0">
                <a href="{{ route('profile.show') }}"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-sm shadow-xs hover:bg-gray-50">
                    View profile
                </a>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 border-t border-gray-300 divide-y divide-gray-300 bg-gray-50 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
        <div class="px-6 py-5 text-sm font-medium text-center">
            <span class="text-gray-600">Epochs Delegated: <span class="text-gray-900">
                    {{$user->meta_data->delegation_length ?? 0 }}
            </span></span>
        </div>

        <div class="px-6 py-5 text-sm font-medium text-center">
            <span class="text-gray-600">Phuffy Coin Balance: </span>
            <span class="text-gray-900">{{$user->phuffycoin_balance ?? 0}}</span>
        </div>

        <div class="px-6 py-5 text-sm font-medium text-center">
            <span class="text-gray-600">Given to causes: </span>
            <span class="text-gray-900">${{$user->meta_data?->donated_amount ?? 0}} USD</span>
        </div>
    </div>
</div>
