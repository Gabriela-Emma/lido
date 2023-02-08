<?php

namespace App\Http\Controllers\ProjectCatalyst;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\CatalystGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CatalystGroupsController extends Controller
{
    public int $perPage = 24;

    public ?string $search = null;

    public ?string $sort = null;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $this->search = $request->input('s', null);
    $this->sort = $request->input('st', null);

       
    return Inertia::render('Groups', [
        'search' => $this->search,
        'sort' => $this->sort,
        'groups' => $this->query($request),
        'crumbs' => [
            ['label' => 'Groups'],
        ],
    ]);
}

public function query(Request $request){
    $query = CatalystGroup::where('status', 'published')
    ->whereHas('proposals', fn ($q) => $q->whereNotNull('funded_at'))
    ->withSum([
        'proposals as amount_awarded' => function ($query) {
            $query->whereNotNull('funded_at');
        }, ],
        'amount_requested')
        ->withSum([
            'proposals as amount_received' => function ($query) {
                $query->whereNotNull('funded_at');
            }, ],
            'amount_received')
        ->when($this->search, function ($query, $search) {
            return $query->where('name', 'iLIKE', "%{$search}%");
        })
        ->when($this->sort, function ($query, $sort) {
            $sortParts = explode(':', $sort);
            return $query->orderBy($sortParts[0], $sortParts[1]);
        });
        $paginator=$query->paginate($this->perPage, ['*'], 'p', $request->input('p'));

        return $paginator->toArray();
    
}

}
