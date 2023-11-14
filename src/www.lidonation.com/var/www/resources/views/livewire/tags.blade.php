<div>
    <x-global.tags :tags="$tags" :bgColor="'bg-teal-600'"/>

    <livewire:components.new-to-library lazy="on-load"/>

    <section class="py-16">
        <div class="container">
            <livewire:components.support-lido-component theme="green" lazy="on-scroll"/>
        </div>
    </section>
</div>
