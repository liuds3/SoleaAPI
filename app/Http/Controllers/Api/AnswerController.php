<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answer;
use Illuminate\Support\Facades\Validator;


class AnswerController extends Controller
{
    
    public function index()
    {
        $answers = Answer::all();
        if($answers->count() > 0)
        {
            return response()->json([
                'status' => 200,
                'answers' => $answers
            ], 200);

        }else{

            return response()->json([
                'status' => 404,
                'message' => "No records found"
            ], 404);
        }
    }

    public function show($id)
    {
        $answer = Answer::find($id);
        if($answer)
        {
            return response()->json([
                'status' => 200,
                'answer' => $answer
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No answer found"
            ], 404);
        }
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
                'question' => 'required|Integer|max:19',
                'user' => 'required|string|max:191',
                'answer' => 'required|string|max:191',
            ]
        );
        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        else{
            $answer = new Answer();
            $answer->question = $request->question;
            $answer->user = $request->user;
            $answer->answer = $request->answer;
            $answer->save();
            return response()->json([
                'status' => 200,
                'message' => "Answer added successfully"
            ], 200);
        }
    }

    public function deleteAnswer($id)
    {
        $answer = Answer::find($id);
        if($answer)
        {
            $answer->delete();
            return response()->json([
                'status' => 200,
                'message' => "Answer deleted successfully"
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No answer found"
            ], 404);
        }
    }

    public function updateAnswer(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(), [
                
                'question' => 'required|Integer|max:19',
                'user' => 'required|string|max:191',
                'answer' => 'required|string|max:191',
            ]
        );
        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $answer = Answer::find($id);
            if($answer)
            {
                $answer->update([
                    'question' => $request->question,
                    'user' => $request->user,
                    'answer' => $request->answer,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Answer updated successfully",
                    'answer' => $answer
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => "No answer found"
                ], 404);
            }
        }   
    }
    

    public function getAnswersByQuestionId($question)
    {
        $answers = Answer::where('question', $question)->get();
        if($answers->count() > 0)
        {
            return response()->json([
                'status' => 200,
                'answers' => $answers
            ], 200);

        }else{

            return response()->json([
                'status' => 404,
                'message' => "No records found"
            ], 404);
        } 
    }
}
