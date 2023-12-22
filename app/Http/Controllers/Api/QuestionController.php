<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        if($questions->count() > 0)
        {
            return response()->json([
                'status' => 200,
                'questions' => $questions
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
        $question = Question::find($id);
        if($question)
        {
            return response()->json([
                'status' => 200,
                'question' => $question
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No question found"
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
                'question' => 'required|string|max:191',
                'content' => 'required|string|max:191',
                'user' => 'required|string|max:191',
            ]
        );
        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $question = Question::create([
                'question' => $request->question,
                'content' => $request->content,
                'user' => $request->user,
            ]);
            

            if($question)
            {
                return response()->json([
                    'status' => 200,
                    'message' => "Question created successfully",
                    'question' => $question
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 500,
                    'message' => "Internal server error"
                ], 500);
            }
        }
        
    }
    //remove question
    public function deleteQuestion($id)
    {
        $question = Question::find($id);
        if($question)
        {
            $question->delete();
            return response()->json([
                'status' => 200,
                'message' => "Question deleted successfully"
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No question found"
            ], 404);
        }
    }
    
    //update question
    public function updateQuestion(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(), [
                'question' => 'required|string|max:191',
                'content' => 'required|string|max:191',
                'user' => 'required|string|max:191',
            ]
        );
        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $question = Question::find($id);
            if($question)
            {
                $question->update([
                    'question' => $request->question,
                    'content' => $request->content,
                    'user' => $request->user,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Question updated successfully",
                    'question' => $question
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => "No question found"
                ], 404);
            }
        }
        
    }

}
