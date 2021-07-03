<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
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
        return $allFeedback->paginate(3)->toJson();
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
        // add status later!!!
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
            return $feedback->toJson();
        }else{
            return "Invalid Id !";
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
        Feedback::where('id', $id)
                ->update($request->all());
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
    }
}
