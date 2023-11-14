@props(['content', 'theme'])
<blockquote class="bg-gray-100 p-6 font-italic border-l-8 border-{{$theme}}-50 mb-4 rounded-tr-sm rounded-br-sm">
    <x-markdown>{{$content}}</x-markdown>
</blockquote>
