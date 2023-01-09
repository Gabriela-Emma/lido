<?php

namespace App\Http\View\Composers\Partners;

use Illuminate\View\View;

class PartnersAppComposer
{
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $user = auth()->user();
        $view->with(compact('user'));
    }
}
