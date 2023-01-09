<?php

namespace App\Repositories;

use App\Models\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AdaRepository extends Repository
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    /**
     * Get Ada fiat quote with 15 minutes of freshness
     *
     * @return object|null
     */
    public function quote(): ?object
    {
        return Cache::remember('adaQuote', 900, fn () => $this->fetchQuote());
    }

    protected function fetchQuote(): ?object
    {
        $adaQuote = null;
        try {
            $response = Http::withHeaders([
                'X-CMC_PRO_API_KEY' => config('services.coinmarketcap.key'),
            ])->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest', [
                'id' => '2010',
            ]);
            if (isset($response['data'])) {
                $data = (object) ($response['data'][2010] ?? null);
                if (isset($data?->quote['USD'])) {
                    $adaQuote = (object) $data?->quote['USD'];
                }
            }
        } catch (\Exception $e) {
            report($e);
        }

        return $adaQuote;
    }
}
