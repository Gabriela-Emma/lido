@props([
    'layout' => 'row'
])
<form method="post" action="{{route('newsletter')}}"
      class="flex flex-{{$layout}} lg:flex-col xl:flex-{{$layout}} justify-center w-full rounded-full mt-3">

    <div class="w-full rounded-l-full">
        <label for="emailAddress" class="sr-only">Email address</label>
        <input
            type="email"
            name="emailAddress"
            id="emailAddress"
            autocomplete="email"
            required
            class="{{$layout === 'row' ? 'bg-slate-300' : ''}} custom-input w-full input h-full border-teal-100 {{$layout === 'row' ? 'rounded-l-full rounded-r-none' : '' }} active:border-teal-600 focus:border-teal-600 focus:ring-teal-600"
            placeholder="Enter your email">
    </div>

    <div class="rounded-r-full">
        <button type="submit" class="hover:bg-white w-full custom-input inline-flex h-full button primary {{$layout === 'row' ? 'rounded-r-full' : ''}} mt-0">
            Subscribe
        </button>
    </div>

    @csrf
</form>
