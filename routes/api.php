<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth', 'check.role:' . User::ROLE_ADMIN])->group(function () {
//get all questions
Route::get('questions', [QuestionController::class, 'index']);  
//get question by id
Route::get('question/{id}', [QuestionController::class, 'show']);
//add question
Route::post('questions', [QuestionController::class, 'store']);
//remove question
Route::delete('question/{id}', [QuestionController::class, 'deleteQuestion']);
//update question
Route::put('question/{id}', [QuestionController::class, 'updateQuestion']);
});

Route::middleware('auth')->group(function () {
//get all answers
Route::get('answers', [AnswerController::class, 'index']);
//get answer by id
Route::get('answer/{id}', [AnswerController::class, 'show']);
//add answer
Route::post('answers', [AnswerController::class, 'store']);
//remove answer
Route::delete('answer/{id}', [AnswerController::class, 'deleteAnswer']);
//update answer
Route::put('answer/{id}', [AnswerController::class, 'updateAnswer']);
//get answers by question id
Route::get('answers/{id}', [AnswerController::class, 'getAnswersByQuestionId']);

//get all likes
Route::get('likes', [LikeController::class, 'index']);
//get like by id
Route::get('like/{id}', [LikeController::class, 'show']);
//add like
Route::post('likes', [LikeController::class, 'store']);
//remove like
Route::delete('like/{id}', [LikeController::class, 'deleteLike']);
//update like
Route::put('like/{id}', [LikeController::class, 'updateLike']);
//get likes by answer id
Route::get('likesAnswer/{id}', [LikeController::class, 'getLikesByAnswerId']);
//get likes by answer id
Route::get('likesQuestion/{id}', [LikeController::class, 'getLikesByQuestionId']);

// Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

    Route::get('users', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::delete('user/{id}', [UserController::class, 'delete']);
    Route::put('user/{id}', [UserController::class, 'update']);
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('users', [UserController::class, 'store']);
// });

