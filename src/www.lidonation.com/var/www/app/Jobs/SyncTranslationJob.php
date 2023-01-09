<?php

namespace App\Jobs;

use App\Models\Model;
use App\Services\TranslationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SyncTranslationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Model $model,
        public string $field,
        public string $source,
        public string $target,
        public bool $publish,
        public bool $prePopulate
    ) {
    }

    /**
     * Execute the job.
     *
     * @param  TranslationService  $translationService
     * @return void
     *
     * @throws ValidationException
     */
    public function handle(TranslationService $translationService): void
    {
        if (! isset($this->model->{$this->field})) {
            $class = $this->model::class;
            throw ValidationException::withMessages([
                "$this->field does not exist on $class",
            ]);
        }

        $content = $this->model->getTranslation($this->field, $this->source, false);
        if (empty($content)) {
            Log::info("nothing to translate for $this->field");

            return;
        }

        $translationService = $translationService
            ->setTargetLang($this->target)
            ->setSourceLang($this->source);

        $existingTranslation = trim($this->model->getTranslation($this->field, $this->target, false));
        if (empty($existingTranslation) && $this->prePopulate) {
            if (collect(config('laravellocalization.supportedLocales'))->keys()->except(['sw'])->contains($this->target)) {
                $translationService = $translationService
                    ->translate($content, $this->target, $this->source);
            }
        } else {
            $translationService->setTranslation($existingTranslation);
        }

        $translationService->save($this->model, $this->field, $this->publish);
    }
}
