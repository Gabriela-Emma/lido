<?php

namespace App\Livewire\ContributeContent;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

class ContributeTranslations extends ModalComponent
{
    public ?string $translatingTo;

    public function mount()
    {
        if (Auth::check()) {
            $locales = config('laravellocalization.supportedLocales');
            $translates = Auth::user()->meta_data?->translates;
            if ((bool) $translates) {
                $this->translatingTo = $locales[$translates]['native'];
            }
        }
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.contribute-content.contribute-translations')->layout('layouts.app', [
            'metaTitle' => 'Contribute Translations',
        ]);
    }
}
