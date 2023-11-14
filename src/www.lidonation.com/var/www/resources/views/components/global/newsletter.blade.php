@props([
    'title' => $snippets->mailingListCta,
    'subTitle' => false,
    'bg' => 'bg-gray-100',
    'classes' => '',
    'layout' => 'row',
])
<div class="{{$bg}} p-6 {{$classes}}">
    <h3 class="">
        @markdownLang($title)
    </h3>
    @if($subTitle)
        <p>
            @markdownLang($subTitle)
        </p>
    @endif
    <x-global.mailchimp-form :layout="$layout" />
</div>
