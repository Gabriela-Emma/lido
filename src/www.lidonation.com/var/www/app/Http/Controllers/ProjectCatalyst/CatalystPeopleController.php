<?php

namespace App\Http\Controllers\ProjectCatalyst;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\CatalystUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalystPeopleController extends Controller
{   
    public int $perPage = 24;

    public ?string $search = null;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {   
        $this->search=$request->input('s',null);

        return Inertia::render('People', [
            'users'=>$this->query($request)->map(fn ($user) =>[
                    'id' => $user->id,
                    'name' => $user->name, 
                    'link'=>$user->link,
                    'profile_photo_url'=>$user->thumbnail_url ?? $user->gravatar,
                    'proposals_count'=>$user->proposals_count,
            ]
            ),
            'crumbs' => [
                ['label' => 'People'],
            ],
        ]);
    }

    public function query(Request $request){
        $query = CatalystUser::query();
        if (isset($this->search)) {
            $query->orWhere('username', 'iLIKE', "%{$this->search}%")
                ->orWhere('name', 'iLIKE', "%{$this->search}%");
        }
        $paginator = $query->paginate($this->perPage);

        return $paginator;
    }

}
