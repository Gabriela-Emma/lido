<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssessorReviewCommentRequest;
use App\Http\Requests\UpdateAssessorReviewCommentRequest;
use App\Models\AssessorReviewComment;

class AssessorReviewCommentController extends Controller
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
     * @param  \App\Http\Requests\StoreAssessorReviewCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssessorReviewCommentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssessorReviewComment  $assessorReviewComment
     * @return \Illuminate\Http\Response
     */
    public function show(AssessorReviewComment $assessorReviewComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssessorReviewComment  $assessorReviewComment
     * @return \Illuminate\Http\Response
     */
    public function edit(AssessorReviewComment $assessorReviewComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAssessorReviewCommentRequest  $request
     * @param  \App\Models\AssessorReviewComment  $assessorReviewComment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssessorReviewCommentRequest $request, AssessorReviewComment $assessorReviewComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssessorReviewComment  $assessorReviewComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssessorReviewComment $assessorReviewComment)
    {
        //
    }
}
