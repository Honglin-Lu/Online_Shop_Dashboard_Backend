<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allFeedback = Feedback::whereNotNull('id');

        if($request->has('name')){
            $allFeedback = Feedback::where('name', $request->name);
        }
        if($request->has('email')){
            $allFeedback = Feedback::where('email', $request->email);
        }
        if($request->has('subject')){
            $allFeedback = Feedback::where('subject', $request->subject);
        }
        if($request->has('status')){
            $allFeedback = Feedback::where('status', $request->status);
        }

        // return response()->json($allFeedback);
        $feedback = $allFeedback->paginate(3);

        if($feedback){
            return $this->successResponse($feedback);
        }else{
            return $this->successResponse(null, 'No Feedback', 404);
        }
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feedback = Feedback::create($request->all());
        if($feedback){
            return $this->successResponse($feedback, 'Feedback Created', 201);
        }else{
            return $this->errorResponse('Store Failed', 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feedback = Feedback::find($id);
        if ($feedback){
            return $this->successResponse($feedback);
        }else{
            return $this->successResponse(null, "Invalid Id !", 404);
        }
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = Feedback::where('id', $id)
                ->update($request->all());
        if ($result === 1){
            $feedback = Feedback::find($id);
            return $this->successResponse($feedback, 'Feedback Updated');
        }else{
            return $this->errorResponse('Update Failed', 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();

        if ($feedback->trashed()){
            return $this->successResponse(null, 'Feedback Deleted');
        }else{
            return $this->errorResponse('Delete Failed', 401);
        }
    }
}
