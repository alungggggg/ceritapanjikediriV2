<?php

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\newsController;
use App\Http\Controllers\quizController;
use App\Http\Controllers\userController;
use App\Http\Controllers\forumController;
use App\Http\Controllers\pilganController;
use App\Http\Controllers\dongengController;
use App\Http\Controllers\visitedController;
use App\Http\Controllers\UraianPanjangController;
use App\Http\Controllers\uraianSingkatController;

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



// dongeng
Route::get('/dongeng', [dongengController::class, 'getDongeng']);
Route::get('/dongeng/{id}', [dongengController::class, 'getDongengById']);


Route::get('/popular', [dongengController::class, 'popularView']);
Route::get('/dongengview/{id}', [dongengController::class, 'sumView']);
Route::get('/count/dongeng', [dongengController::class, 'countDongeng']);
Route::get('/count/view', [dongengController::class, 'countAllView']);



// news
Route::get('/news', [newsController::class, 'index']);

// auth
Route::post('/login', [authController::class, 'login']); 
Route::post('/logout', [authController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [authController::class, 'register']); //x
Route::get('/auth/alreadyexist/email', [authController::class, 'isAvailableEmail']);
Route::get('/auth/alreadyexist/username', [authController::class, 'isAvailableUsername']);
Route::get('/auth/email', [authController::class, 'checkEmail']);
Route::post('/forgot-password', [authController::class, 'forgotPasswordSend']); // x
Route::post('/forgot-password/{token}', [authController::class, 'forgotPasswordForm']); // x
Route::post('/refresh-token', [authController::class, 'forgotPasswordForm']); // x
Route::get('/isvalidtoken/{token}', [authController::class, 'forgotPasswordForm']); //x
Route::get('/verify', [authController::class, 'forgotPasswordForm']); //x


Route::middleware(['auth:sanctum'])->group(function () {
    
    // dongeng
    Route::post('/dongeng', [dongengController::class, 'createDongeng'])->middleware('auth:sanctum');
    Route::patch('/dongeng/{id}', [dongengController::class, 'updateDongeng'])->middleware('auth:sanctum');
    Route::delete('/dongeng/{id}', [dongengController::class, 'deleteDongeng'])->middleware('auth:sanctum');

    // user
    Route::get('/profile', [userController::class, 'profile'])->middleware('auth:sanctum');
    Route::get('/profile/update/{id}', [userController::class, 'updateProfile'])->middleware('auth:sanctum');
    Route::get('/users/{id}', [userController::class, 'getUserByID'])->middleware('auth:sanctum');; // admin
    Route::get('/users', [userController::class, 'getUser'])->middleware('auth:sanctum');;
    Route::post('/users', [userController::class, 'createUser'])->middleware('auth:sanctum');
    Route::patch('/users/{id}', [userController::class, 'updateUser'])->middleware('auth:sanctum');
    Route::delete('/users/{id}', [userController::class, 'deleteUser'])->middleware('auth:sanctum');

    // news
    Route::post('/news', [newsController::class, 'store'])->middleware('auth:sanctum');
    Route::patch('/news', [newsController::class, 'update'])->middleware('auth:sanctum'); // admin
    Route::delete('/news', [newsController::class, 'destroy'])->middleware('auth:sanctum'); // admin

    // pilgan
    Route::post('/set-soal-pilgan', [pilganController::class, 'createSoalPilgan']);
    Route::get('/get-soal-pilgan', [pilganController::class, 'getSoalPilgan']);
    Route::delete('/delete-soal-pilgan/{id}', [pilganController::class, 'deleteSoalPilgan']);
    Route::patch('/update-soal-pilgan/{id}', [pilganController::class, 'updateSoalPilgan']);

    // uraian singkat
    Route::get('/get-soal-uraian-singkat', [uraianSingkatController::class, 'getSoalUraianSingkat']);
    Route::post('/set-soal-uraian-singkat', [uraianSingkatController::class, 'createSoalUraianSingkat']);
    Route::delete('/delete-soal-uraian-singkat/{id}', [uraianSingkatController::class, 'deleteSoalUraianSingkat']);
    Route::patch('/update-soal-uraian-singkat/{id}', [uraianSingkatController::class, 'updateSoalUraianSingkat']);

    // uraian panjang
    Route::get('/get-soal-uraian-panjang', [UraianPanjangController::class, 'getSoalUraianPanjang']);
    Route::post('/set-soal-uraian-panjang', [UraianPanjangController::class, 'createSoalUraianPanjang']);
    Route::delete('/delete-soal-uraian-panjang/{id}', [UraianPanjangController::class, 'deleteSoalUraianPanjang']);
    Route::patch('/update-soal-uraian-panjang/{id}', [UraianPanjangController::class, 'updateSoalUraianPanjang']);

    // quiz
    Route::get('/get-all-quiz', [quizController::class, 'getAllQuiz']);
    Route::post('/create-quiz', [quizController::class, 'createQuiz']);
    Route::delete('/delete-quiz/{id}', [quizController::class, 'deleteQuiz']);
    Route::patch('/update-quiz/{id}', [quizController::class, 'updateQuiz']);
    Route::get('/get-quiz/{id}', [quizController::class, 'getQuizById']);

    // forum
    Route::post('/join-forum', [forumController::class, 'joinForumByToken']);
    Route::post('/update-nilai-quiz', [forumController::class, 'updateNilaiQuiz']);
    Route::get('/get-forum-by-userid/{id_user}', [forumController::class, 'getQuizByUserId']);
    Route::get('/get-rekap-quiz/{id}', [forumController::class, 'getRekapById']);

});



// forum
Route::get('/get-rekap/{id_forum}', [forumController::class, 'getRekapByForumId']);


Route::get('/visited', [visitedController::class, 'newVisited']);
Route::get('/visited/get', [visitedController::class, 'getAllVisited']);

Route::get('/history/{id}', [UraianPanjangController::class, 'getSoalUraianPanjang']);
Route::post('/history/update', [UraianPanjangController::class, 'getSoalUraianPanjang']);


// Route::get('/test', function(){
//     Mail::to('aldinoalungputraanugraha@gmail.com')->send(new WelcomeMail('John Doe'));
// });
Route::get('/yuser', function(Request $request){
    return $request->user();
})->middleware('auth:sanctum');