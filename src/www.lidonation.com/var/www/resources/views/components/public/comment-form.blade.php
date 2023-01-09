@props(['modelType', 'modelId', 'parentId', 'authorId', 'prompt' => 'Leave a comment'])
<div class="border rounded-sm" id="commentForm">
    @if($errors->isNotEmpty())
        <x-public.errors :errors="$errors"></x-public.errors>
    @elseif(session()->has('message'))
        <div class="flex flex-row justify-center p-8">
            <div class="rounded-md bg-accent-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: solid/check-circle -->
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xl font-medium text-black">
                            {{ session()->get('message') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <form class="w-full bg-white  px-4 pt-2" method="post" action="/comment" enctype="multipart/form-data">
        @csrf

        <x-honeypot/>

        @if(isset($modelType))
            <input type="hidden" name="model_type" value="{{$modelType}}" />
        @endif

        @if(isset($modelId))
            <input type="hidden" name="model_id" value="{{$modelId}}" />
        @endif

        @if(isset($modelId))
            <input id="parentId" type="hidden" name="parent_id" value="" />
        @endif

        <div class="mb-6">
            <div class="max-w-3xl">
                <h2 class="pt-3 pb-2">{{$prompt}}</h2>
            </div>
            <div class="my-4">
                <div class="sm:col-span-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Name
                    </label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" value="{{ old('title') }}"
                               class="px-3 border focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400">
                    </div>
                </div>
            </div>
            <div class="my-4">
                <div class="sm:col-span-3">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <div class="mt-1">
                        <input type="text" name="email" id="email" value="{{ old('email') }}"
                               class="border px-3 focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400">
                    </div>
                </div>
            </div>
            <div class="my-4">
                <div class="sm:col-span-3">
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Comment Title
                    </label>
                    <div class="mt-1">
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                               class="border px-3 focus:ring-primary-500 focus:border-primary-500 block w-full border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400">
                    </div>
                </div>
            </div>
            <div class="w-full md:w-full my-2">
                <label>
                        <textarea value="{{ old('content') }}"
                            class="bg-gray-100 rounded px-2 border border-gray-300 leading-normal resize-none w-full h-60 py-2 px-3 font-medium placeholder-gray-700 focus:ring-1 focus:ring-primary-500 focus:ring-offset-primary-400 focus:outline-none focus:bg-white focus:bg-white"
                            name="content" placeholder='Type Your Comment*' required></textarea>
                </label>
            </div>
        </div>

        <div class="mb-6 px-4">
            <div class="recaptcha">
                {!!  GoogleReCaptchaV3::renderField('post_comment_id','post_comment') !!}
            </div>

            <div class="flex items-start my-4">
                <input type='submit'
                       class="bg-teal-600 text-white font-medium py-1 px-4 rounded-sm tracking-wide mr-1 hover:bg-teal-800 outline-none border-none cursor-pointer"
                       value='Post Comment'>
            </div>
        </div>
    </form>
</div>


