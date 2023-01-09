<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssessorReviewRequest;
use App\Http\Requests\UpdateAssessorReviewRequest;
use App\Models\AssessorReview;

class AssessorReviewController extends Controller
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
     * @param  \App\Http\Requests\StoreAssessorReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssessorReviewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssessorReview  $assessorReview
     * @return \Illuminate\Http\Response
     */
    public function show(AssessorReview $assessorReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssessorReview  $assessorReview
     * @return \Illuminate\Http\Response
     */
    public function edit(AssessorReview $assessorReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAssessorReviewRequest  $request
     * @param  \App\Models\AssessorReview  $assessorReview
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssessorReviewRequest $request, AssessorReview $assessorReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssessorReview  $assessorReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssessorReview $assessorReview)
    {
        //
    }
}
