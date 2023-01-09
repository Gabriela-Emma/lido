<?php

namespace App\Models\Interfaces;

use App\Models\Model;

interface IHasTranslations
{
    public function saveLanguageLines(Model &$model);
}
