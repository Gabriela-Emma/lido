<?php

namespace App\Services;

use App\Models\Model;
use App\Models\Translation;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TranslationService
{
    protected string $targetLang;

    protected string $originalText;

    protected ?string $translation;

    protected string $sourceLang;

    public function setSourceLang(string $sourceLang): self
    {
        $this->sourceLang = $sourceLang;

        return $this;
    }

    public function setTranslation(string $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    public function setTargetLang(string $targetLang): self
    {
        $this->targetLang = $targetLang;

        return $this;
    }

    public function get(): ?string
    {
        return $this->translation;
    }

    public function translate(string $text, ?string $targetLang, string $sourceLang = 'EN'): self
    {
        $this->sourceLang = $this->sourceLang ?? $sourceLang ?? app()->getLocale();
        $this->originalText = $text;
        $this->targetLang = $this->targetLang ?? $targetLang;
        $this->fetchTranslation();

        return $this;
    }

    public function save(Model|Translation $model, string $field, bool $publish = false): self
    {
        $sourceLang = $model->source_lang ?? app()->getLocale();
        $targetLang = Str::lower($this->targetLang);
        Translation::updateOrCreate(
            [
                'source_id' => $model->source_id ?? $model->id,
                'source_type' => $model->source_type ?? $model::class,
                'source_field' => $model->source_field ?? $field,
                'source_lang' => $sourceLang,
                'lang' => $targetLang,
            ],
            [
                'source_id' => $model->source_id ?? $model->id,
                'source_type' => $model->source_type ?? $model::class,
                'source_field' => $model->source_field ?? $field,
                'source_content' => $model->source_content ?? $model->getTranslation($field, $sourceLang, false),
                'source_lang' => $model->source_lang ?? $this->sourceLang,
                'published_at' => $publish ? now() : null,
                'status' => $publish ? 'published' : 'draft',
                'lang' => $targetLang,
                'content' => $this->translation ?? trim($model->getTranslation($field, $this->targetLang, false)),
            ]
        );

        return $this;
    }

    protected function fetchTranslation(): self
    {
        $translation = null;
        try {
            $headers = [
                'DeepL-Auth-Key' => config('services.deepl.auth_key'),
            ];
            $url = 'https://api.deepl.com/v2/translate';
            $content = collect(breakLongText($this->originalText))
                ->map(fn ($text) => ([
                    'target_lang' => $this->targetLang,
                    'source_lang' => $this->sourceLang,
                    'text' => $text,
                    'auth_key' => config('services.deepl.auth_key'),
                ]));
            $responses = collect(Http::pool(
                fn (Pool $pool) => $content->map(
                    fn ($content) => $pool->withHeaders($headers)->get($url, $content)
                )
            ));

            if ($responses->every(fn ($res) => $res->ok())) {
                $responses = $responses->map(fn ($res) => collect($res->object()?->translations)?->first());
                if ($responses->isNotEmpty()) {
                    $translation = $responses->map(fn ($translation) => $translation->text)->implode(' ');
                }
            }
        } catch (\Exception $e) {
            report($e);
        }

        $this->translation = $translation;

        return $this;
    }
}
