<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommetnController;
use App\Http\Controllers\RatingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Movie;
use App\Models\Rating;
use App\Models\Commetn;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('/');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/movies', function () {
    // if(auth()->user()) {
    //     auth()->user()->assignRole('admin');
    // }
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'movies' => MovieController::index(),
    ]);
})->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/', function() {
        return Inertia::render('Admin/Index' ,[
            'statistic' => [
                'userCount' => count(User::all()),
                'movieCount' => count(Movie::all()),
                'ratingCount' => count(Rating::all()),
                'commentCount' => count(Commetn::all()),
            ],
            'blabal' => 'asdkfj'
        ]);
    })->name('index');
    Route::resource('/movies', \App\Http\Controllers\Admin\MovieController::class);
    Route::resource('/genres', \App\Http\Controllers\Admin\GenreController::class);
    Route::resource('/countries', \App\Http\Controllers\Admin\CountryController::class);
    Route::resource('/actors', \App\Http\Controllers\Admin\ActorController::class);
    Route::resource('/comments', \App\Http\Controllers\Admin\CommentController::class);
    Route::resource('/ratings', \App\Http\Controllers\Admin\RatingController::class);
    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
    // Route::resource('/avatar', \App\Http\Controllers\Admin\AvatarController::class);

}); 


Route::get('/movies/{id}', function ($id) {
    return Inertia::render('Movie', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'movie' => MovieController::show($id),
        'comments' => CommetnController::index($id),
        'isFavorite' => UserController::movieIsFavorite($id),
    ]);
})->name('movie.show');

Route::resource('comments', CommetnController::class)
->only(['store', 'update', 'destroy'])
->middleware(['auth', 'verified']);

Route::resource('ratings', RatingController::class)
->only(['store', 'update' ])
->middleware(['auth', 'verified']);

Route::post('user', [UserController::class, 'storeInFavorite'])
->name('user.storeInFavorite');

Route::put('user', [UserController::class, 'deleteFromFavorite'])
->name('user.deleteFromFavorite');

Route::get('user', [UserController::class, 'movieIsFavorite'])
->name('user.movieIsFavorite');

// Route::resource('user', UserController::class)
// ->only(['storeInFavorite', 'deleteFromFavorite' ])
// ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/avatar', [AvatarController::class, 'update'])->name('avatar.update');
    Route::post('/admin-avatar', [\App\Http\Controllers\Admin\AvatarController::class, 'update'])->name('admin.avatar.update');
    Route::post('/admin-poster', [\App\Http\Controllers\Admin\PosterController::class, 'update'])->name('admin.poster.update');
    Route::put('/admin-trailer', [\App\Http\Controllers\Admin\TrailerController::class, 'update'])->name('admin.trailer.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/phpinfo', function() {
    return phpinfo();
});

require __DIR__.'/auth.php';
