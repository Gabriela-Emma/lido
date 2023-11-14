<div class="relative">
    <div class="absolute top-0 left-0 z-30 flex items-center justify-center hidden w-full h-full bg-white opacity-75"
        wire:loading.class.remove="hidden">
        <x-theme.spinner theme="teal" square="16" />
    </div>
    <form method="POST" wire:submit="submit" class="w-full space-y-8">
        @csrf

        @if ($promo->media?->isEmpty())
            <div>
                <label class="block text-sm font-medium text-gray-700">Promo Image</label>
                <div
                    class="flex flex-col justify-center px-16 py-8 mt-1 border border-gray-300 rounded-sm xl:px-32 xl:py-16">

                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                    2560x2560px)</p>
                                <input wire:model='promoUpload' id="dropzone-file" type="file" class="hidden" />
                            </div>
                        </label>
                    </div>

                    <p class="text-xs text-gray-500 pt-2 px-0.5">
                        any square image at least 640 x 640 up to 10MB
                    </p>

                    @error('promoUpload')
                        <div class="flex flex-col gap-2 p-2 mt-2 text-xs text-red-600 bg-red-50">
                            <div>
                                <span class="error">{{$message}}</span>
                            </div>
                            {{-- <div>
                                <span class="error">Image height must be same size as with between 640 and 1920
                                    pixels</span>
                            </div>
                            <div>
                                <span class="error">You can only upload one image</span>
                            </div>
                            <div>
                                <span class="error">Image cannot be larger than 10mb</span>
                            </div> --}}
                        </div>
                    @enderror
                </div>
            </div>
        @else
            <div class="relative">
                <div
                    class="absolute z-20 right-6 top-6 inline-flex items-center rounded-sm bg-eggplant-500 py-0.5 pl-2.5 pr-1 text-sm font-medium text-teal-400">
                    Delete
                    <button type="button" wire:click="deleteMedia({{ $promo->media->first()?->id }})"
                        class="inline-flex items-center justify-center flex-shrink-0 w-4 h-4 ml-1 text-teal-400 rounded-full hover:bg-teal-200 hover:text-teal-500 focus:bg-teal-500 focus:text-white focus:outline-none">
                        <span class="sr-only">Delete Promo</span>
                        <svg class="w-2 h-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                        </svg>
                    </button>
                </div>

                <div class="z-0 aspect-w-3 aspect-h-3">
                    <img class="z-0 object-cover rounded-md shadow-lg"
                        src="{{ $promo->getFirstMediaUrl('hero', 'preview') }}" alt="{{ $promo->title }}'s promo image">
                </div>
            </div>
        @endif

        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-2 xl:col-span-3">
                <label for="uri" class="block text-sm font-medium text-gray-700">Website</label>
                <div class="flex my-1 rounded-sm shadow-sm">
                    <span
                        class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-sm bg-gray-50">website</span>
                    <input type="text" name="uri" id="uri" placeholder="https://www.example.com"
                        wire:model="promo.uri"
                        class="flex-1 block w-full border-gray-300 rounded-none rounded-r-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                </div>
                @error('promo.uri')
                    <span class="text-red-800 error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-2 xl:col-span-3">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <div class="flex my-1 rounded-sm shadow-sm">
                    <input type="text" name="title" id="title" wire:model="title"
                        class="flex-1 block w-full border-gray-300 rounded-none rounded-r-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                </div>
                @error('title')
                    <span class="text-red-800 error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
            <div class="mt-1">
                <textarea id="content" name="content" rows="3" wire:model="content"
                    class="block w-full border-gray-300 rounded-sm shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"></textarea>
            </div>
            <p class="my-2 text-sm text-gray-500">
                280 Characters Max
            </p>
            @error('content')
                <span class="text-red-800 error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
            class="inline-flex items-center gap-2 px-6 py-3 text-lg font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm xl:text-xl hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
            </svg>
            <span>Save Promotion</span>
        </button>
    </form>
</div>
