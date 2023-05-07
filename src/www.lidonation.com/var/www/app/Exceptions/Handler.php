<?php

namespace App\Exceptions;

use App\Models\Proposal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    protected array $ignoredTables = [
        'pool_retire',
        'epoch',
        'block',
        'pool_update',
        'utxo_view',
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if ($e instanceof ModelNotFoundException) {
            if ($e->getModel() === Proposal::class) {
                $term = $request->route()->parameter('proposal');
                $slug = Str::remove(['-f6', '-f7', '-f8', '-f9'], $term);
                $proposals = Proposal::with('fund.parent')
                    ->where('slug', 'LIKE', "%$slug%")->get();
                if (is_iterable($proposals) && $proposals->count() > 0) {
                    if ($proposals->count() > 1) {
                        $proposals = $proposals->sortByDesc('fund.parent.launched_at');

                        return response()->view('errors.proposals', compact('proposals', 'term'), 200);
                    } elseif ($proposals->count() == 1) {
                        $proposal = $proposals->first();

                        return redirect()->to($proposal->link, 301);
                    }
                }
            }
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (QueryException $e) {
            if (Str::contains($e->getSql(), $this->ignoredTables)) {
                Log::warning($e->getMessage());
            } else {
                throw $e;
            }
        })->stop();

        //        $this->reportable(function (Throwable $e) {
        //            //
        //        });

        $this->reportable(function (InvalidArgumentException $e) {
            Log::warning($e->getMessage());
        })->stop();
    }
}
