<?php
// $media = Post::find(66)->media->first()->getSrcset('thumbnail')


// Tag::inRandomOrder()
//                         ->limit(4)
//                         ->pluck('id')
//                         ->mapToGroups(fn($tax) => [
//                             $tax => [ 'model_type' => Post::class ]])


//   ->map(fn($set) => $set->collapse())


// Post::withCount([
//   'media' => fn ($query) => $query->where('media.collection_name', 'audio')
// ])->get()
  // ->flatMap(function ($media) {
  //     return [
  //       $media->slug => $media->media_count
  //     ];
  // })->toArray();


Tag::first()->models()->withTrashed()->get();
// dd($query->toSql(), $query->getBindings());
// ->models()->toSql()


// Post::first()->tags->withTrashed();

// $query = Post::find(5)->tags();
// dd($query->toSql(), $query->getBindings())


// Post::find(45)->tags