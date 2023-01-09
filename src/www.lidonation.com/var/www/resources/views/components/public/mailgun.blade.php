<section class="relative py-16 px-4">
    <div class="container mx-auto z-20">
        <div class="max-w-2xl text-white">
            <h2 class="text-7xl font-medium">
                The future is for everyone.
            </h2>
            <p class="my-6">
                Blockchain news, insights, and resources in your inbox.
            </p>

            <!-- Contact form -->
            @if(old())
                <div class="py-10 lg:col-span-2">
                    Success!
                </div>
            @else
                <div class="py-10 lg:col-span-2 max-w-lg">
                    <h3 class="text-lg font-medium">Email Address</h3>
                    <x-public.mailchimp-form></x-public.mailchimp-form>
                </div>
            @endif
        </div>
    </div>
</section>
