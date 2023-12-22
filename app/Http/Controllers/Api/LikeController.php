<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function index()
    {
        $likes = Like::all();
        if($likes->count() > 0)
        {
            return response()->json([
                'status' => 200,
                'likes' => $likes
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
        $like = Like::find($id);
        $like = Like::find($id);
        if($like)
        {
            return response()->json([
                'status' => 200,
                'like' => $like
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No like found"
            ], 404);
        }
    }

    public function store(Request  $request)
    {
        $validator = Validator::make(
            $request->all(), [
                'QuestionId' => 'required|Integer|max:11',
                'AnswerId' => 'required|Integer|max:11',
                'UserId' => 'required|Integer|max:11',
                'likedOrDisliked' => 'required|Integer|max:11',
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
            $like = new Like();
            $like->QuestionId = $request->QuestionId;
            $like->AnswerId = $request->AnswerId;
            $like->UserId = $request->UserId;
            $like->likedOrDisliked = $request->likedOrDisliked;
            $like->save();
            return response()->json([
                'status' => 200,
                'message' => "Like created successfully"
            ], 200);
        }
    }

    public function deleteLike($id)
    {
        $like = Like::find($id);
        if($like)
        {
            $like->delete();
            return response()->json([
                'status' => 200,
                'message' => "Like deleted successfully"
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No like found"
            ], 404);
        }
    }

   
    public function updateLike(Request $request, $id)
    {
        $like = Like::find($id);
        if($like)
        {
            $validator = Validator::make(
                $request->all(), [
                    'QuestionId' => 'required|Integer|max:11',
                    'AnswerId' => 'required|Integer|max:11',
                    'UserId' => 'required|Integer|max:11',
                    'likedOrDisliked' => 'required|Integer|max:11',
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
                $like->QuestionId = $request->QuestionId;
                $like->AnswerId = $request->AnswerId;
                $like->UserId = $request->UserId;
                $like->likedOrDisliked = $request->likedOrDisliked;
                $like->save();
                return response()->json([
                    'status' => 200,
                    'message' => "Like updated successfully"
                ], 200);
            }
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No like found"
            ], 404);
        }
    }

    public function getLikesByQuestionId($id)
    {
        $likes = Like::where('QuestionId', $id)->get();
        if($likes->count() > 0)
        {
            return response()->json([
                'status' => 200,
                'likes' => $likes
            ], 200);

        }else{

            return response()->json([
                'status' => 404,
                'message' => "No records found"
            ], 404);
        }
    }
    public function getLikesByAnswerId($id)
    {
        $likes = Like::where('AnswerId', $id)->get();
        if($likes->count() > 0)
        {
            return response()->json([
                'status' => 200,
                'likes' => $likes
            ], 200);

        }else{

            return response()->json([
                'status' => 404,
                'message' => "No records found"
            ], 404);
        }
    }
}
