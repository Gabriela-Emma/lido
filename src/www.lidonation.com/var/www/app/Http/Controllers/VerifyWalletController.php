<?php

namespace App\Http\Controllers;

use App\Services\CardanoMintService;
use App\Services\CardanoWalletService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Fluent;
use Whoops\Exception\ErrorException;

class VerifyWalletController extends Controller
{
    public function hasLidoNft(CardanoWalletService $cardanoWalletService): Response|bool|Application|ResponseFactory|null
    {
        try {
            if ($cardanoWalletService->hasLidoNft()) {
                return response(json_encode(true), 200);
            } else {
                return response(json_encode(false), 403);
            }
        } catch (RequestException | ErrorException $e) {
            return response($e->getMessage(), $e->getCode() > 100 ? $e->getCode() : 500);
        }
    }

    public function getValidationAddress(Request $request, CardanoWalletService $cardanoWalletService): Fluent|Response|Application|ResponseFactory|null
    {
        try {
            return $cardanoWalletService->getDepositCliAddress(
                $request->get('create_if_missing', true)
            );
        } catch (RequestException | ErrorException $e) {
            return response($e->getMessage(), $e->getCode() > 100 ? $e->getCode() : 500);
        }
    }

    public function getValidationWalletBalance(CardanoWalletService $cardanoWalletService): Fluent|Response|Application|ResponseFactory|int|null
    {
        try {
            return $cardanoWalletService->getCliDepositBalance();
        } catch (RequestException | ErrorException $e) {
            return response($e->getMessage(), $e->getCode() > 100 ? $e->getCode() : 500);
        }
    }

    public function getValidationWalletDelegation(CardanoWalletService $cardanoWalletService): Response|Application|ResponseFactory
    {
        try {
            $isDelegator = $cardanoWalletService->isCliDelegator();
            if ($isDelegator === null) {
                return response(json_encode('Not Found'), 404);
            } elseif ($isDelegator) {
                return response(json_encode(true), 200);
            } else {
                return response(json_encode(false), 403);
            }
        } catch (RequestException $e) {
            return response($e->getMessage(), $e->getCode() > 100 ? $e->getCode() : 500);
        }
    }

    public function getValidationWalletRefund(CardanoWalletService $cardanoWalletService): Response|float|int|Application|ResponseFactory
    {
        return $cardanoWalletService->getRefundAmount();
    }

    public function issueValidationWalletRefund(CardanoMintService $cardanoMintService): Response|bool|Application|ResponseFactory
    {
        try {
            $res = $cardanoMintService->mint();
            if ($res === null) {
                return response('Error issuing a refund. Please email us for further support.', 400);
            }

            return $res;
        } catch (RequestException | ErrorException $e) {
            return response($e->getMessage(), $e->getCode() > 100 ? $e->getCode() : 400);
        }
    }
}
