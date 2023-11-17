<?php

namespace App\Livewire\Partners;

use App\Livewire\Forms\AuthenticationForm;
use App\Models\User;
use Livewire\Component;

class RegistrationComponent extends Component
{
    public AuthenticationForm $form;

    public function render()
    {
        return view('livewire.partners.registration');
    }

    public function create()
    {
        $user = $this->form->store();
        if ($user instanceof User) {
            return $this->redirect('/partners', navigate: true);
        } else {
            return response()->json([
                'message' => 'We are having trouble logging you in with your stake address. Try your email and password or try registering again.',
            ], 401);
        }
    }
}
