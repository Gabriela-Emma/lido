<?php

namespace App\Livewire\Partners\LidoMinute;

use App\Models\Promo;
use Livewire\Component;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Foundation\Application;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Livewire\WithFileUploads;

class PromoComponent extends Component
{
    use WithFileUploads;

    public Promo $promo;

    public string $title;

    public string $content;

    public ?string $message = null;

    public $mediaComponentNames = ['promoUpload'];

    // #[Rule('mimes:jpeg,jpg,png|max:10240')] 
    public $promoUpload;

    public function rules(): array
    {
        return [
            'promo.uri' => 'string',
            'title' => 'required|string|max:60',
            'content' => 'max:280',
        ];
    }

    public function mount()
    {
        $this->title = $this->promo?->title;
        $this->content = $this->promo?->content;
    }

    public function deleteMedia(Media $media): Redirector|Application|RedirectResponse
    {
        $media->delete();

        return redirect(request()->header('Referer'));
    }

    public function submit()
    {
        $this->validate();
        $this->promo->setTranslation('title', 'en', $this->title)
            ->setTranslation('content', 'en', $this->content)
            ->save();

        if ($this->promoUpload) {
            $this->promo
                ->addMedia($this->promoUpload)
                ->usingName($this->promo->title)
                ->toMediaCollection('hero');
        }

        $this->message = 'Your form has been submitted';
        // $this->clearMedia();
    }

    public function render()
    {

        return view('livewire.partners.promo');
    }
}
