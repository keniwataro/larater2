<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ウェルカム画面
Route::get('/', function () {
    return view('welcome');
});

// ダッシュボード画面
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ツイート関連の処理
Route::middleware('auth')->group(function () {

    // タイムラインルート（これが上に来ていないとresourceのやつにぶつかる）
    Route::get('/tweet/timeline', [TweetController::class, 'timeline'])->name('tweet.timeline');

    // 検索用ルート（これが上に来ていないとresourceのやつにぶつかる）
    Route::get('/tweet/search/input', [SearchController::class, 'create'])->name('search.input');
    Route::get('/tweet/search/result', [SearchController::class, 'index'])->name('search.result');
    
    //マイページ 
    Route::get('/tweet/mypage', [TweetController::class, 'mydata'])->name('tweet.mypage');

    // お気に入り登録用
    Route::post('tweet/{tweet}/favorites', [FavoriteController::class, 'store'])->name('favorites');
    Route::post('tweet/{tweet}/unfavorites', [FavoriteController::class, 'destroy'])->name('unfavorites');

    // フォロー用ルート
    Route::post('user/{user}/follow', [FollowController::class, 'store'])->name('follow');
    Route::post('user/{user}/unfollow', [FollowController::class, 'destroy'])->name('unfollow');

    // ユーザーページルート
    Route::get('user/{user}', [FollowController::class, 'show'])->name('follow.show');

    // ツイート処理まとめ（まとめ処理は一番後ろにもっていってた方が無難）
    Route::resource('tweet', TweetController::class);
});



// 認証したら行う処理一覧（元からあるやつ）
Route::middleware('auth')->group(function () {
    // プロフィール編集用
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


// 認証用まとめルートファイル
require __DIR__.'/auth.php';
