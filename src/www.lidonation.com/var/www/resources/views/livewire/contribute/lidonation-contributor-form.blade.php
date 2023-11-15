<div class="bg-gray-100">
    <x-contribute.header title="Contributor Sign Up Form"
        subTitle="Fill in the details below to sign up to be a Lido Nation contributor" />

    @if ($show)
        <div class="bg-gray-100 flex items-center justify-center py-6">
            <div class="bg-gray-100 mb-6 w-full container">
                <div class="text-gray-600 flex flex-col justify-center rounded shadow-md p-4 px-4 bg-white">
                    <div class="flex items-start gap-4">
                        <p class="text-black font-bold text-lg">Form successfully submitted</p>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        </span>
                    </div>
                    <p>Thank you for your interest in contributing to our cause. We have received your contributor
                        form submission and it is currently being reviewed by our team. We will be in touch about
                        your application and provide you with more information..</p>
                </div>
            </div>
        </div>
    @endif

    @if (!$show)
        <div class="bg-gray-100 flex items-center justify-center py-6">
            <div class="bg-gray-100 mb-6 w-full container">
                <div>
                    <form wire:submit="save">
                        <div
                            class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6 bg-white rounded shadow-md p-4 px-4">
                            <div class="md:col-span-5">
                                <h3>Sign up form</h3>
                            </div>
                            <div class="md:col-span-5">
                                <label for="full_name">Full Name</label>
                                <input wire:model="fullName" type="text" name="full_name" id="full_name"
                                    class="h-10 mt-1 px-4 w-full bg-gray-50 outline-none border border-gray-100 rounded-sm text-sm focus:border-blue-500"
                                    value="" placeholder="John Doe" />
                                <div class="text-sm text-red-600">
                                    @error('fullName')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="md:col-span-5">
                                <label for="email">Email Address</label>
                                <input wire:model="email" type="email" name="email" id="email"
                                    class="h-10 mt-1 px-4 w-full bg-gray-50 outline-none border border-gray-100 rounded-sm text-sm focus:border-blue-500"
                                    value="" placeholder="email@domain.com" />
                                <div class="text-sm text-red-600">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="md:col-span-3">
                                <label for="password">Password</label>
                                <input wire:model="password" type="password" name="password" id="password"
                                    class="h-10 mt-1 px-4 w-full bg-gray-50 outline-none border border-gray-100 rounded-sm text-sm focus:border-blue-500"
                                    value="" placeholder="*******" />
                                <div class="text-sm text-red-600">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label for="password_confirm">Confirm password</label>
                                <input wire:model="passwordConfirm" type="password" name="password_confirm"
                                    id="password_confirm"
                                    class="h-10 mt-1 px-4 w-full bg-gray-50 outline-none border border-gray-100 rounded-sm text-sm focus:border-blue-500"
                                    value="" placeholder="*******" />
                                <div class="text-sm text-red-600">
                                    @error('passwordConfirm')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="md:col-span-3">
                                <label for="twitter">Twitter</label>
                                <input wire:model="twitter" type="text" name="twitter" id="twitter"
                                    class="h-10 mt-1 px-4 w-full bg-gray-50 outline-none border border-gray-100 rounded-sm text-sm focus:border-blue-500"
                                    value="" placeholder="Optional" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="telegram">Telegram</label>
                                <input wire:model="telegram" type="text" name="telegram" id="telegram"
                                    class="h-10 mt-1 px-4 w-full bg-gray-50 outline-none border border-gray-100 rounded-sm text-sm focus:border-blue-500"
                                    value="" placeholder="Optional" />
                            </div>

                            <div class="md:col-span-5">
                                <label for="areas_of_interest" class="block text-sm font-medium">Areas of
                                    interest (You can select more than one.)</label>
                            </div>

                            <div class="md:col-span-5">
                                <div class="flex flex-col gap-2">
                                    @foreach ($options as $value => $label)
                                        <div class="border border-gray-100 rounded-sm bg-gray-50 py-3 px-2">
                                            <label for="{{ $value }}" class="mr-2 ">{{ $label }}</label>
                                            <input type="checkbox" value="{{ $value }}" wire:model="interests">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-sm text-red-600">
                                    @error('interests')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="md:col-span-5 flex items-center gap-4 justify-end">
                                @if ($loading)
                                    <div role="status">
                                        <svg aria-hidden="true"
                                            class="inline w-6 h-6 text-gray-200 animate-spin fill-green-600"
                                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="currentColor" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentFill" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="inline-flex items-end">
                                    <button type="submit"
                                        class="bg-slate-900 hover:bg-slate-600 text-white font-bold py-2 px-4 rounded">Submit</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
