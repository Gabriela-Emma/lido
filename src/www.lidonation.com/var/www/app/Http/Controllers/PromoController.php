<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\PromoData;
use App\Http\Requests\StorePromoRequest;
use App\Http\Requests\UpdatePromoRequest;
use App\Models\Nft;
use App\Models\Promo;
use App\Models\Tx;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     *
     * @throws ValidationException
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromoRequest $request): Promo
    {
        $promo = new Promo;
        $promo->user_id = auth()->user()?->getAuthIdentifier();
        $mintTx = Tx::whereJsonContains('metadata->mint_tx_hash', $request->mint_tx)->firstOrFail();
        $promo->token_id = $mintTx->model->id;
        $promo->token_type = Nft::class;
        $promo->save();

        return $promo;
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Promo $promo)
    {
        return PromoData::from(Promo::inRandomOrder()->first()
            ->setAppends([
                'feature_url',
            ])->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Promo $promo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(UpdatePromoRequest $request, Promo $promo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Promo $promo)
    {
        //
    }
}
