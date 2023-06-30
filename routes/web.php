<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
    return view('welcome');
});

//? Principal
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');

//? Articles
// Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
// Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
// Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

// Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
// Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
// Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

//ESTAS RUTAS SE PUEDEN MODIFICAR DE ESTA MANERA
Route::resource('articles', ArticleController::class)
    ->except('show')
    ->names('articles'); //esto genera todas las rutas descritas anteriormente

//? Categories
Route::resource('categories', CategoryController::class)
    ->except('show') //excepto las routas que no se vayan a usar en este caso 'show'
    ->names('categories');

//Ver Articulos
Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');

//Ver articulos por Categorias
Route::get('category/{category}', [CategoryController::class, 'detail'])->name('categories.detail');

//? Comentarios
Route::resource('comments', CommentController::class)
    ->only('index', 'destroy')
    ->names('comments');

//Guardar los comentarios
Route::get('/comment', [CommentController::class, 'store'])->name('comments.store');


Auth::routes();
