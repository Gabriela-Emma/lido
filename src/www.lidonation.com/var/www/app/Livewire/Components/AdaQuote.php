<?php

namespace App\Livewire\Components;

use App\Http\Integrations\Coinmarketcap\CoinMarketCapConnector;
use App\Http\Integrations\Coinmarketcap\Requests\GetQuoteRequest;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AdaQuote extends Component
{
    public ?object $adaQuote;

    public ?bool $tableView;

    public function mount()
    {
        try {
            $connector = new CoinMarketCapConnector();
            $request = new GetQuoteRequest(2010);
            $response = $connector->send($request);
            $adaQuote = $response->json()['data'][2010]['quote']['USD']['price'];
            $this->adaQuote = (object) ['price' => $adaQuote];
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function render()
    {
        return view('livewire.components.ada-quote');
    }
}
