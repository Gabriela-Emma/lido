<?php
// namespace
trait HasReactions {
    public function reactions() {}

    public function hearts() {
        return $this->hasMany(ReactionHeart::class, 'model_id')
            ->where('type', static::class);
    }

    public function thumbs_up() {}
    
    public function thumbs_down() {}
}
