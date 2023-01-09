@props(['formAction' => false])
<div class="relative z-50">
    @if($formAction)
        <form wire:submit.prevent="{{ $formAction }}">
    @endif

            @isset($title)
            <header class="bg-white p-2 lg:p-4 lg:px-6 lg:py-4 border-b border-gray-150">
                @if(isset($title))
                    <h2 class="">
                        {{ $title }}
                    </h2>
                @endif
            </header>
            @endisset

            <section class="bg-white">
                <div class="space-y-6">
                    {{ $content }}
                </div>
            </section>

            @isset($buttons)
            <footer class="bg-white px-4 pb-5 mt-4 sm:px-4 sm:flex">
                <div class="flex justify-end items-center gap-4">
                    {{ $buttons }}
                </div>
            </footer>
            @endisset
    @if($formAction)
        </form>
    @endif
</div>
