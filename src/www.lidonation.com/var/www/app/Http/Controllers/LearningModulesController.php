<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLearningModulesRequest;
use App\Http\Requests\UpdateLearningModulesRequest;
use App\Models\LearningModule;

class LearningModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLearningModulesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLearningModulesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LearningModule  $learningModules
     * @return \Illuminate\Http\Response
     */
    public function show(LearningModule $learningModules)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LearningModule  $learningModules
     * @return \Illuminate\Http\Response
     */
    public function edit(LearningModule $learningModules)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLearningModulesRequest  $request
     * @param  \App\Models\LearningModule  $learningModules
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLearningModulesRequest $request, LearningModule $learningModules)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LearningModule  $learningModules
     * @return \Illuminate\Http\Response
     */
    public function destroy(LearningModule $learningModules)
    {
        //
    }
}
