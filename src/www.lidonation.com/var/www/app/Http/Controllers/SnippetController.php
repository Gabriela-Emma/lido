<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SnippetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $snippets = DB::table('snippets')->get();
        $snippetsRes = [];
        foreach ($snippets as $snippet) {
            $snippetContent = json_decode($snippet->content);
            foreach ($snippetContent as $key => $value) {
                $snippetsRes[$key][$snippet->name] = $value;
            }
        }

        //update the disk storage file
        Storage::disk('local')->put('snippets.json', json_encode($snippetsRes));

        return $snippetsRes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Snippet $snippet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Snippet $snippet): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Snippet $snippet): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function destroy(Snippet $snippet)
    {
        //
    }
}
