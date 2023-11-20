<div class="antialiased space-y-4">
    @foreach($reviews as $review)
        <div class="border-t py-2 sm:py-4 first:border-t-0" wire:key="{{$review->id}}">
            <livewire:discussions.review-component :editable="false" :review="$review" :discussion="$discussion" />
        </div>
    @endforeach
</div>
