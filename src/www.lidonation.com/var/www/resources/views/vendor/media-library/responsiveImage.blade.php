<img{!! $attributeString !!}@if($loadingAttributeValue) loading="{{ $loadingAttributeValue }}"@endif
srcset="{{ $media->getSrcset($conversion) }}"
src="{{ $media->getUrl($conversion) }}" width="{{ $width }}"
height="{{ $height }}"
class="w-32 h-20 object-cover rounded-tl-[7rem] rounded-tr-[5rem] rounded-br-[4rem] rounded-bl-[0.5rem] bg-teal-600 filter hover:contrast-200 "
/>
