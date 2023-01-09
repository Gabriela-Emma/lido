<?php

namespace App\Shortcodes;

use App\Models\Proposal;

class ProposalsShortcode
{
    public function register($shortcode, $content, $compiler, $name, $viewData)
    {
        $proposals = Proposal::find(explode(',', $shortcode->ids));

        return view('shortcodes.proposals', ['proposals' => $proposals]);
    }
}
