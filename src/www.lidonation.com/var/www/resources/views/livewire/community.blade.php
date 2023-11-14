<div class="community" title="LIDO Community">

    <div class="p-16 container">
        <div class="flex flex-col gap-1">
            <span class='font-light text-[60px]'>{{__('Lido Nation') }}</span><br/>
            <span class='font-black text-teal-600 text-[60px]'>{{__('Community') }}.</span>
        </div>

        <div class=" mt-12">
            <p>
                Lido Nation is a global community of people who believe the future is for everyone.<br/>
                Together we are learning, teaching, and building the world we want to see.<br/>
            </p>

            <p>
                We are glad you are here.
            </p>
        </div>
    </div>

    <section class="relative" id="send-a-message">
        <livewire:contact-lido-component/>
    </section>


    <section class="py-16">
        <div class="container">
            <livewire:components.support-lido-component theme="green" lazy="on-scroll"/>
        </div>
    </section>
</div>
