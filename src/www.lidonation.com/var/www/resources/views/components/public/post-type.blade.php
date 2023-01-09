@props([
    'post',
    'size' => 'xs',
    'textColor' => 'text-slight-50',
    'borderColor' => 'border-transparent',
    'badge' => true
])
@if($post)
    <a
        href="{{$post->post_type_url}}"
        class="inline-flex items-center px-2 py-0.5 ml-0.5 capitalize text-white hover:text-slate-600 rounded-sm text-xs font-semibold bg-post-type-{{$post->post_type_name}} {{$textColor}} border border-post-type-{{$post->post_type_name}}">
      {{$post->post_type_name}}
    </a>
@endif
