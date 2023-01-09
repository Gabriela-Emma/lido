<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssessmentReviewRequest;
use App\Http\Requests\UpdateAssessmentReviewRequest;
use App\Models\AssessmentReview;

class AssessmentReviewController extends Controller
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
     * @param  \App\Http\Requests\StoreAssessmentReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssessmentReviewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssessmentReview  $assessmentReview
     * @return \Illuminate\Http\Response
     */
    public function show(AssessmentReview $assessmentReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssessmentReview  $assessmentReview
     * @return \Illuminate\Http\Response
     */
    public function edit(AssessmentReview $assessmentReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAssessmentReviewRequest  $request
     * @param  \App\Models\AssessmentReview  $assessmentReview
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssessmentReviewRequest $request, AssessmentReview $assessmentReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssessmentReview  $assessmentReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssessmentReview $assessmentReview)
    {
        //
    }
}
