@props(['model'])
<div class="border rounded-sm p-4">
    <div class="grid grid-cols-4">
        <div>
            @if($model->hero)
                <img class="w-20 h-20 rounded-full" src="{{$model->hero->getUrl('thumbnail')}}">
            @endif
        </div>
        <div class="col-span-3">
            <a href="/posts/{{$model->slug}}/"
               class="text-base font-semibold hover:text-teal-600">
                {{$model->title}}
            </a>
        </div>
    </div>
</div>
