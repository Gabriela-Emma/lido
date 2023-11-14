<?php

namespace App\Livewire\Contribute;

use App\Enums\StatusEnum;
use App\Models\Signup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;

class LidonationContributorForm extends Component
{
    public string $metaTitle = 'Lido Nation contributor registration';

    #[Rule('required|min:3|string|max:255')]
    public string $fullName = '';

    #[Rule('required|email|string|max:255')]
    public string $email = '';

    #[Rule('required|min:6')]
    public string $password = '';

    #[Rule('required|same:password')]
    public string $passwordConfirm = '';

    public string $twitter = '';

    public string $telegram = '';

    public bool $show = false;

    public bool $loading = false;

    #[Rule('required')]
    public $interests = [];

    public array $options = [
        'Catalyst data enrichment' => 'Catalyst data enrichment',
        'Translate lido content (qualified as CF ambassador work)' => 'Translate lido content (qualified as CF ambassador work)',
    ];

    public function save()
    {
        $this->validate();
        $this->loading = true;
        $signupData = [
            'fullName' => $this->fullName,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'twitter' => $this->twitter,
            'telegram' => $this->telegram,
            'interests' => $this->interests,
        ];

        $jsonPayload = json_encode($signupData);

        Signup::create([
            'payload' => $jsonPayload,
            'status' => StatusEnum::PENDING->value,
        ]);

        $this->show = true;
        $this->loading = false;
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.contribute.lidonation-contributor-form');
    }
}
