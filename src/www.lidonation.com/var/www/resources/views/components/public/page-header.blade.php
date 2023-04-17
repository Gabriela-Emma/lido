@props([
    'size' => 'default',
    'headerClass' => 'mb-4 text-5xl leading-none xl:text-9xl',
    'wrapperClass' => 'pb-8 pt-12 sm:py-4 md:py-14'
    ])

<section {{ $attributes->merge(['class' => $wrapperClass]) }}>
    <div class='container'>
        <div class="capitalize max-w-2xl xl:max-w-3xl pr-16 rounded-r-full bg-white relative">
            @switch($size)
                @case('sm')
                    <h1 class='mb-4 text-2xl leading-none xl:text-3xl'>
                        {{ $title }}
                    </h1>
                    @break
                @case('md')
                    <h1 class='mb-4 text-4xl leading-none xl:text-6xl'>
                        {{ $title }}
                    </h1>
                    @break
                @case('lg')
                    <h1 class='mb-4 text-5xl leading-none xl:text-8xl'>
                        {{ $title }}
                    </h1>
                    @break

                @default
                    <h1 {{ $attributes->merge(['class' => $headerClass]) }}>
                        {{ $title }}
                    </h1>
            @endswitch
        </div>

        <div class='flex flex-row flex-wrap items-end justify-between'>
            <div class='max-w-2xl xl:max-w-3xl pr-2 font-medium z-10'>
                {{ $slot }}
            </div>

            @if( $announcement ?? false )
                <div class='pl-10 mt-8 ml-auto md:-mt-20 w-80'>
                    <p class='text-right'>
                        {{ $announcement }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>
