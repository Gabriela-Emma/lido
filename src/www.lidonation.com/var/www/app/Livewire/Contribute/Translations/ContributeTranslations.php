<?php

namespace App\Livewire\Contribute\Translations;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use LivewireUI\Modal\ModalComponent;

#[Layout('layouts.contribute')]
class ContributeTranslations extends ModalComponent
{
    public ?string $translatingTo;

    public ?Collection $translations;

    public function mount()
    {
            $locales = config('laravellocalization.supportedLocales');
            $translates = Auth::user()?->meta_data?->translates;

            // get list of translations

            // present

            // build filters

            // allow user to filter list

            // link individual translation to single transation edit page
            if ((bool) $translates) {
                $this->translatingTo = $locales[$translates]['native'];
        }
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.contribute.translations.index');
    }
}
