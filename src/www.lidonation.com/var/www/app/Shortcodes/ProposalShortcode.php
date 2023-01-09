<?php

namespace App\Shortcodes;

use App\Models\Proposal;

class ProposalShortcode
{
    public function register($shortcode, $content, $compiler, $name, $viewData): string
    {
        $proposal = Proposal::find($shortcode->id);

        return view('shortcodes.proposal', ['proposal' => $proposal]);
    }
}
