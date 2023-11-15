<div class="labs">
    <section class="bg-white w-full">
        <div class="container relative bg-white py-16 w-full">
            <div
                class="flex flex-col gap-8 lg:flex-row flex-nowrap items-center justify-between overflow-y-hidden lg:overflow-y-visible mb-16">
                <div class="shrink-0">
                    <div
                        class="z-10 flex flex-col font-semibold text-labs-black text-5xl md:text-6xl lg:text-7xl xl:text-7xl 2xl:text-8xl">
                        <span class="block">{{__('LIDO') }}</span>
                        <span class="block">{{__('Blockchain') }}</span>
                        <span class="block">{{__('Labs') }}</span>
                    </div>
                    <p class="mt-3 mb-1 text-lg xl:text-xl font-normal text-gray-600 sm:mt-2">
                        <span class="text-2xl">Hands on experiences</span> <br/>
                        building on Cardano in <strong>Nairobi</strong>.
                    </p>
                </div>
                <div class="shrink relative flex flex-col justify-center md:items-center">
                    <div class="max-w-sm md:max-w-md xl:max-w-lg z-10 bg-white pt-16 border-8 border-black">
                        <img class="block logo responsive" src="{{asset('img/lido-blockchain-lab.jpg')}}"
                             alt="LIDO Blockchain Lab"/>
                    </div>
                    <div class="absolute w-full h-full z-0 left-[-28rem] md:left-[-20rem] top-[-2rem]">
                        @include('svg.lido-blockchain-labs-blob')
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-t-8 border-labs-slate-200 py-16 bg-slate-100 shadow-inner">
        <div class="container">
            <div class="text-center mb-10">
                <div class="flex gap-2 justify-center items-center">
                    <div class="w-40 h-40 aspect-square">
                        <img src="{{asset('img/nrbl-logo.png')}}" alt="Ngong Road Blockchain Lab Logo">
                    </div>
                    <h2 class="flex flex-col">
                        <span class="font-semibold text-2xl lg:text-5xl xl:text-7xl">
                            Ngong Road
                        </span>
                        <span class="font-medium text-xl lg:text-4xl xl:text-6xl">
                            Blockchain Lab
                        </span>
                    </h2>
                </div>
            </div>

            <div class="flex flex-col items-center gap-4 w-full">
                <ul class="justify-center flex flex-wrap gap-y-1.5 gap-x-2 flex-row list-outside text-2xl max-w-2xl text-white z-20 relative">
                    <li class="inline-flex items-center break-words box-decoration-clone leading-none bg-labs-green rounded-sm px-2.5 py-2">
                        <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3"/>
                        </svg>
                        Developer Mentorship
                    </li>
                    <li class="inline-flex items-center break-words box-decoration-clone leading-none bg-labs-yellow-light rounded-sm px-2.5 py-2 text-slate-800">
                        <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3"/>
                        </svg>
                        Swahili + English technical translation
                    </li>
                    <li class="inline-flex items-center break-words box-decoration-clone leading-none bg-labs-red-light rounded-sm px-2.5 py-2">
                        <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3"/>
                        </svg>
                        Project Catalyst Proposal Assessor Training
                    </li>
                    <li class="inline-flex items-center break-words box-decoration-clone leading-none bg-teal-light-300 rounded-sm px-2.5 py-2 text-teal-800">
                        <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3"/>
                        </svg>
                        Cardano Community Building
                    </li>
                </ul>
                <div class="font-bold text-xl xl:text-4xl">
                    Nairobi, Kenya
                </div>
            </div>
        </div>
    </section>

    <section class="border-t-8 border-labs-red py-16 bg-labs-red-light shadow-inner">
        <div class="container text-white">
            <div class="flex flex-row flex-nowrap gap-2">
                <div class="hidden lg:block w-96">

                </div>
                <div class="max-w-xl">
                    <h2 class="mb-8 font-bold">
                        Swahili + English Translation
                    </h2>
                    <div>
                        <p>
                            Translators engage in study and weekly mentoring meetings to gain broad understanding of
                            blockchain and Cardano.
                            Specialized translations require specialized knowledge!
                        </p>

                        <p>Written, video and voiceover available</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-t-8 border-labs-green py-16 bg-labs-green-light shadow-inner">
        <div class="container text-white">
            <div class="flex flex-row flex-nowrap gap-2">
                <div class="hidden lg:block w-96">

                </div>
                <div class="max-w-xl">
                    <h2 class="mb-8 font-bold">
                        Project Catalyst Proposal Assessor Training
                    </h2>
                    <div class="pt-2">
                        <p>
                            Using training curriculum designed by Lido Nation and hosted at blockchainlearning.center,
                            new recruits learn how to participate in Project Catalyst and Proposal Assessors.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white border-t-8 border-slate-100">
        <div class="mx-auto max-w-7xl py-12 px-6 lg:px-8 lg:py-24">
            <div class="space-y-12">
                <ul role="list"
                    class="space-y-12 sm:grid sm:grid-cols-2 xl:grid-cols-3 sm:items-start sm:gap-x-4 sm:gap-y-12 sm:space-y-0">
                    <li>
                        <div class="space-y-4 sm:grid sm:grid-cols-3 sm:gap-2 sm:space-y-0 lg:gap-4">
                            <div class="aspect-w-3 aspect-h-2 h-0 sm:aspect-w-3 sm:aspect-h-4">
                                <img class="rounded-lg object-cover shadow-lg"
                                     src="{{asset('img/sallyanne-headshot.jpg')}}"
                                     alt=""/>
                            </div>
                            <div class="sm:col-span-2">
                                <div class="space-y-4">
                                    <div class="space-y-1 text-lg font-medium leading-6">
                                        <h2>
                                            Sallyanne
                                        </h2>
                                        <p class="text-slate-700">
                                            Translator , PA Trainer, Voiceover talent
                                        </p>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="space-y-4 sm:grid sm:grid-cols-3 sm:gap-2 sm:space-y-0 lg:gap-4">
                            <div class="aspect-w-3 aspect-h-2 h-0 sm:aspect-w-3 sm:aspect-h-4">
                                <img class="rounded-lg object-cover shadow-lg"
                                     src="{{asset('img/tabitha-headshot.jpg')}}"
                                     alt=""/>
                            </div>
                            <div class="sm:col-span-2">
                                <div class="space-y-4">
                                    <div class="space-y-1 text-lg font-medium leading-6">
                                        <h2>
                                            Tabitha
                                        </h2>
                                        <p class="text-slate-700">
                                            Translator , PA Trainer
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="space-y-4 sm:grid sm:grid-cols-3 sm:gap-2 sm:space-y-0 lg:gap-4">
                            <div class="aspect-w-3 aspect-h-2 h-0 sm:aspect-w-3 sm:aspect-h-4">
                                <img class="rounded-lg object-cover shadow-lg"
                                     src="{{asset('img/perpetual-headshot.jpg')}}"
                                     alt=""/>
                            </div>
                            <div class="sm:col-span-2">
                                <div class="space-y-4">
                                    <div class="space-y-1 text-lg font-medium leading-6">
                                        <h2>
                                            Perpetual
                                        </h2>
                                        <p class="text-slate-700">
                                            Translator
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="border-t-8 border-labs-yellow bg-labs-yellow-light">
        <div class="container py-16">
            <div class="flex flex-row flex-nowrap gap-16">
                <div class="hidden lg:block w-80">
                    <div class="w-40h-40aspect-squarefloat-leftpr-2">
                        <img src="{{asset('img/lido-blockchain-labs-color.jpg')}}" alt="Ngong Road Blockchain Lab Logo">
                    </div>
                </div>
                <div class="max-w-xl">
                    <h2 class="mb-8 font-bold">
                        Lido Nation Developer Apprenticeship
                    </h2>
                    <div class="pt-2">
                        <p>
                            Qualified and motivated apprentices work through a
                            rigorous course and get hands-on experience with developing in the Cardano ecosystem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-100 border-y-8 border-slate-200">
        <div class="container py-16">
            <div class="flex flex-col gap-2">
                <div class="pr-8">
                    <div class="w-40 h-40 aspect-square float-left pr-2">
                        <img src="{{asset('img/nrbl-logo.png')}}" alt="Ngong Road Blockchain Lab Logo">
                    </div>
                    <p>
                        The <b>Ngong Road Blockchain Lab</b> was founded on April 1, 2022,
                        thanks to the votes of the Cardano Community in Project Catalyst Fund 7.
                        The Lab proposal built on work that had begun in Nairobi, Kenya, to translate educational
                        content
                        about
                        Cardano and Blockchain into Swahili, and to train promising young techies as web developer
                        mentees.
                        In 9 months, this funding accomplished so much!
                    </p>
                </div>

                <div class="flex flex-col items-center w-full mb-8">
                    <ul class="list list-disc lg:ml-4 flex flex-col gap-4 justify-center max-w-4xl">
                        <li>
                            Built a physical lab space for translators and mentees to work and collaborate, including
                            furnishings
                        </li>
                        <li>
                            Purchased high-powered computers for developer trainees, and laptops for translators.
                        </li>
                        <li>
                            Provided internet and electricity for the lab's first 9 months.
                        </li>
                        <li>
                            Paid trainees a salary so that they could commit to learning.
                        </li>
                        <li>
                            Onboarded 8 new translators and developer mentees into the Cardano ecosystem.
                        </li>
                        <li>
                            Provided in-person Proposal Assessor training to an additional 7 new recruits
                        </li>
                        <li>
                            Started to network with other Cardano projects in Nairobi and in the Swahili-speaking world
                            -
                            seeing the Lab start to blossom into a community is a key success metric!
                        </li>
                    </ul>
                </div>

                <div class="my-8">
                    <ul class="grid sm:grid-cols-2 lg:grid-cols-6 gap-4" x-data x-masonry.poll.2500>
                        <li class="text-white rounded lg:col-span-3">
                            <img src="https://storage.googleapis.com/www.lidonation.com/8669/Elimu-Hub-FONR.jpg"
                                 alt="Elimu hub">
                        </li>

                        <li class="text-white rounded lg:col-span-3">
                            <img
                                src="https://storage.googleapis.com/www.lidonation.com/8667/Proposal-Assessor-Training.jpg"
                                alt="Proposal Assessor training session">
                        </li>

                        <li class="text-white rounded lg:col-span-6">
                            <img
                                src="https://storage.googleapis.com/www.lidonation.com/8672/Ngong-Road-Blockchain-Lab-Translators.jpg"
                                alt="Proposal Assessor training session">
                        </li>
                    </ul>
                </div>

                <div>
                    <a href="//twitter.com/NgongRoadLab" target="_blank"
                       class="font-medium text-labs-black hover:text-labs-red flex items-center justify-center gap-2 text-xl lg:text-2xl xl:text-4xl">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                        </svg>
                        <span class="">
                            @NgongRoadLab
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

