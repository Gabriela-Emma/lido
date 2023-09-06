@props(['model', 'editable' => true, 'expanded' => false])
<div class="antialiased">
    <div class="">
        @foreach($model->discussions as $discussion)
            <div class="{{$loop->odd ? 'bg-gray-100' : ''}}">
                <livewire:discussions.discussion-component
                :editable="$editable" :wire:key="$discussion->id"
                :discussion="$discussion" :model="$model" :background="$loop->odd ? 'bg-gray-100' : 'bg-white'"
                :expanded="$expanded" />
            </div>
        @endforeach
    </div>
</div>
