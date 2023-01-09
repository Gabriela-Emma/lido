@props([
    'mints'
])
@if($mints && is_iterable($mints))
    <ul class="divide-y divide-white border-t border-white mt-6">
        @foreach($mints as $mint)
            <li class="py-4 {{$mint->status === 'minted' ? 'text-gray-200': ''}}">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div
                            class="rounded-full w-16 h-16 flex flex-col justify-center items-center bg-white font-semibold text-gray-700">
                            @if($mint->mint_seed_amount)
                                <span class="text-sm">₳{{$mint->mint_seed_amount / 1000000}}</span>
                            @else
                                <span class="text-sm">-</span>
                            @endif
                            <span class="font-medium text-xs">{{$mint->epoch}}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0 flex flex-row gap-6  text-center">
                        <div class="flex flex-col justify-center items-center">
                            <div class="font-semibold text-md">
                                {{$mint->memo}}
                            </div>
                            <div class="text-xs text-gray-100 font-medium">
                                Memo
                            </div>
                        </div>
                        <div class=" flex flex-col justify-center items-center">
                            <div class="font-semibold text-md">
                                {{$mint->author->name}}
                            </div>
                            <div class="text-xs text-gray-200 font-medium">
                                Started By
                            </div>
                        </div>
                        <div class=" flex flex-col justify-center items-center">
                            <div class="font-semibold text-md">
                                {{$mint->created_at->diffForHumans()}}
                            </div>
                            <div class="text-xs text-gray-100 font-medium">
                                Created
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{route('mint', ['mintId' => $mint->id])}}"
                           type="button"
                           class="inline-flex text-xs items-center px-2 py-1 border border-transparent shadow-sm font-medium rounded-sm text-teal-800 hover:text-yellow-900 bg-white hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            {{$mint->status === 'minted' ? 'View': 'Resume'}}
                        </a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif
