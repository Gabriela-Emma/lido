<div class="relative">
    <div class="bg-white opacity-75 hidden absolute w-full h-full left-0 top-0 flex justify-center items-center z-30"
         wire:loading.class.remove="hidden">
        <x-theme.spinner theme="teal" square="16"/>
    </div>
    <form method="POST" wire:submit.prevent="submit" class="w-full space-y-8">
        @csrf

        @if($promo->media?->isEmpty())
            <div>
                <label class="block text-sm font-medium text-gray-700">Promo Image</label>
                <div
                    class="mt-1 flex flex-col justify-center rounded-sm border border-gray-300 px-16 xl:px-32 py-8 xl:py-16">
                    <div class="text-center">
                        <x-media-library-attachment
                            :media="$promo->media"
                            :editable-name="true"
                            name="promoUpload"
                            rules="mimes:jpeg,jpg,png|max:10240|dimensions:ratio=1/1|dimensions:min_width=640,max_width=2560|dimensions:min_height=640,max_height=2560"/>
                    </div>
                    <p class="text-xs text-gray-500 pt-2 px-0.5">
                        any square image at least 640 x 640 up to 10MB
                    </p>

                    @error('promoUpload')
                    <div class="mt-2 flex flex-col gap-2 p-2 bg-red-50 text-red-600 text-xs">
                        <div>
                            <span class="error">Image width must be same size as with between 640 and 1920 pixels</span>
                        </div>
                        <div>
                            <span
                                class="error">Image height must be same size as with between 640 and 1920 pixels</span>
                        </div>
                        <div>
                            <span class="error">You can only upload one image</span>
                        </div>
                        <div>
                            <span class="error">Image cannot be larger than 10mb</span>
                        </div>
                    </div>
                    @enderror
                </div>
            </div>
        @else
            <div class="relative">
                <div
                    class="absolute z-20 right-6 top-6 inline-flex items-center rounded-sm bg-eggplant-500 py-0.5 pl-2.5 pr-1 text-sm font-medium text-teal-400">
                    Delete
                    <button type="button"
                            wire:click="deleteMedia({{$promo->media->first()?->id}})"
                            class="ml-1 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full text-teal-400 hover:bg-teal-200 hover:text-teal-500 focus:bg-teal-500 focus:text-white focus:outline-none">
                        <span class="sr-only">Delete Promo</span>
                        <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"/>
                        </svg>
                    </button>
                </div>

                <div class="aspect-w-3 aspect-h-3 z-0">
                    <img class="rounded-md object-cover shadow-lg z-0"
                         src="{{$promo->getFirstMediaUrl('hero', 'preview')}}" alt="{{$promo->title}}'s promo image">
                </div>
            </div>
        @endif

        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-2 xl:col-span-3">
                <label for="uri" class="block text-sm font-medium text-gray-700">Website</label>
                <div class="my-1 flex rounded-sm shadow-sm">
                    <span
                        class="inline-flex items-center rounded-l-sm border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">website</span>
                    <input type="text" name="uri" id="uri" placeholder="https://www.example.com"
                           wire:model.defer="promo.uri"
                           class="block w-full flex-1 rounded-none rounded-r-sm border-gray-300 focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                </div>
                @error('promo.uri') <span class="error text-red-800">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-2 xl:col-span-3">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <div class="my-1 flex rounded-sm shadow-sm">
                    <input type="text" name="title" id="title" wire:model.defer="title"
                           class="block w-full flex-1 rounded-none rounded-r-sm border-gray-300 focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                </div>
                @error('title') <span class="error text-red-800">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
            <div class="mt-1">
                <textarea id="content" name="content" rows="3"
                          wire:model.defer="content"
                          class="block w-full rounded-sm border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"></textarea>
            </div>
            <p class="my-2 text-sm text-gray-500">
                280 Characters Max
            </p>
            @error('content') <span class="error text-red-800">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
                class="inline-flex gap-2 items-center rounded-sm border border-transparent bg-teal-600 px-6 py-3 text-lg xl:text-xl font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
            </svg>
            <span>Save Promotion</span>
        </button>
    </form>
</div>
