<?php

namespace App\Http\View\Composers;

use App\Repositories\DefinitionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class DefinitionsComposer
{
    private array|Collection $definitions;

    /**
     * Create a new profile composer.
     *
     * @param  DefinitionRepository  $definitionRepository
     */
    public function __construct(protected DefinitionRepository $definitionRepository)
    {
        $this->definitions = $this->definitionRepository->all();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'definitions' => $this->definitions,
        ]);
    }
}
