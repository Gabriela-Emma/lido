<?php

namespace App\Models;

use App\Models\CatalystExplorer\Assessment;
use Parental\HasParent;

class Prompt extends Assessment
{
    use HasParent;

    protected $with = ['metas'];

    protected $appends = ['question', 'answer'];

    public function getQuestionAttribute()
    {
        return $this->name;
    }

    public function getAnswerAttribute()
    {
        return $this->content;
    }
}
