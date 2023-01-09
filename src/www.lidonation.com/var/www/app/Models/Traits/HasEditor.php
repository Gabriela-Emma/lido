<?php

namespace App\Models\Traits;

use App\Models\User;

trait HasEditor
{
    public function getEditorAttribute(): ?User
    {
        return User::find($this->meta_data?->editor);
    }

    public function getEditorIdAttribute(): ?User
    {
        return $this->meta_data?->editor;
    }
}
