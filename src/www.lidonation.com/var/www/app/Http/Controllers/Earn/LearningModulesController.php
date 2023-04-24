<?php

namespace App\Http\Controllers\Earn;

use App\DataTransferObjects\LearningModuleData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLearningModulesRequest;
use App\Http\Requests\UpdateLearningModulesRequest;
use App\Models\LearningModule;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LearningModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $learningModules = LearningModule::with('topics.lessons')
            ->withCount(['topics'])->published();
        return Inertia::render('LearningModules', [
            'modules' => LearningModuleData::collection($learningModules->paginate(12)->onEachSide(0)),
            'crumbs'  => [
                ['name' => 'Learn & Earn', 'link' => route('earn.learn')],
                ['name' => 'Learning Modules', 'link' => route('earn.learn.modules.index')],
            ]
        ]);
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
     * @param StoreLearningModulesRequest $request
     * @return Response
     */
    public function store(StoreLearningModulesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param LearningModule $learningModule
     * @param Request|null $request
     * @return \Inertia\Response
     */
    public function show(LearningModule $learningModule, ?Request $request)
    {
        $learningModule->load('topics');
        $learningModule->loadCount(['topics']);
        return Inertia::render('LearningModule', [
            'module' => $learningModule->load('topics.lessons'),
            'crumbs' => [
                ['name' => 'Learn & Earn', 'link' => route('earn.learn')],
                ['name' => 'Learning Modules', 'link' => route('earn.learn.modules.index')],
                ['name' => $learningModule->title, 'link' => route('earn.learn.modules.view', $learningModule->id)],
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LearningModule $learningModules
     * @return Response
     */
    public function edit(LearningModule $learningModules)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLearningModulesRequest $request
     * @param LearningModule $learningModules
     * @return Response
     */
    public function update(UpdateLearningModulesRequest $request, LearningModule $learningModules)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LearningModule $learningModules
     * @return Response
     */
    public function destroy(LearningModule $learningModules)
    {
        //
    }
}
