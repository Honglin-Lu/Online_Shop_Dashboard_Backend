<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\FeedbackAnswer;
use App\Models\Feedback;



class FeedbackAnswerController extends ApiController
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $answer = new FeedbackAnswer;
        $answer->feedback_id = $request->feedback_id;
        $answer->answer = $request->answer;
        $answer->add_user_type = 0;
        $result = $answer->save();
        if($result){
            $feedback = Feedback::find($request->feedback_id);
            $feedback->status = $request->status;
            $feedback->save();
            return $this->successResponse($answer, 'FeedbackAnswer Created', 201);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getAnswers($id){
        $answers = FeedbackAnswer::where('feedback_id', $id)->orderBy('id', 'desc')->get();
        //$newDateFormat = $answer->created_at->format('Y-m-d H:i:s');
        // dump($answer);
        // exit();
        if($answers){
            // foreach ($answers as $answer){
            //     $answer->created_at->format('Y-m-d H:i:s');
            //     //dd($newDateFormat);
            // }
            return $this->successResponse($answers);
        }else{
            return $this->successResponse(null, "No answer found !", 404);
        }
    }
}
