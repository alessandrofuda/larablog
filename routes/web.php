<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


// Route::controller('/', 'FrontendController'); --> deprecata da L5.3

// Frontend
Route::get('/', 'FrontendController@index');
Route::get('articolo/{slug}', 'FrontendController@articolo');
Route::get('autore/{slug}', 'FrontendController@autore');
Route::get('categoria/{slug}', 'FrontendController@categoria');


//Login Authorization --> aggiunti automaticamente con 'php artisan make:auth'
Route::get('/backend', 'Backend\DashboardController@index');  //dashboard
Auth::routes(
	//Backend
	Route::get('backend/users', 'Backend\UserController@index'), //;
	Route::get('backend/users/add', 'Backend\UserController@add'),
	Route::post('backend/users/add', 'Backend\UserController@add_with_post_method'),
	Route::get('backend/users/edit/{user_id}', 'Backend\UserController@edit'),
	Route::post('backend/users/edit/{user_id}', 'Backend\UserController@edit_post'),
	Route::get('backend/users/delete/{user_id}', 'Backend\UserController@delete'),
	//Route::post('backend/users/delete/{user_id}', 'Backend\UserController@delete'); TRASLARE DA GET A POST

	Route::get('backend/myprofile', 'Backend\UserController@myprofile'),
	Route::get('backend/myprofile/update', 'Backend\UserController@update_my_prof'),
	Route::post('backend/myprofile/update', 'Backend\UserController@update_my_prof_post_method'),
	Route::post('backend/myprofile/delete', 'Backend\UserController@delete_my_prof_post_method'),

	Route::get('backend/categories', 'Backend\CategoryController@index'),
	Route::get('backend/categories/add', 'Backend\CategoryController@add'),
	Route::post('backend/categories/add', 'Backend\CategoryController@add_post_method'),
	Route::get('backend/categories/edit/{cat_id}', 'Backend\CategoryController@edit'),
	Route::post('backend/categories/edit/{cat_id}', 'Backend\CategoryController@edit_post_method'),
	// Route::get('backend/categories/delete/{cat_id}', 'Backend\CategoryController@delete'),
	Route::post('backend/categories/delete/{cat_id}', 'Backend\CategoryController@delete'),

	Route::get('backend/articles', 'Backend\ArticleController@index'),
	Route::get('backend/articles/add', 'Backend\ArticleController@add'),
	Route::post('backend/articles/add', 'Backend\ArticleController@add_post_method'),
	Route::get('backend/articles/edit/{art_id}', 'Backend\ArticleController@update'),
	Route::post('backend/articles/edit/{art_id}', 'Backend\ArticleController@update_with_post_method'),
	Route::post('backend/articles/delete/{art_id}', 'Backend\ArticleController@delete_with_post_method'),

	Route::get('backend/my-articles', 'Backend\ArticleController@my_articles')

);

//Route::get('/', function () {
    // return view('welcome');
//});

/*

Route::get('/', function () {

    //elenco categorie per il menù
    $categories = \App\Category::all();

    // prelevo gli articoli (includendo i dati sulle rispettive categorie ed autore associati)
    $articles = \App\Article::with('categories', 'user')
    	->where('published_at', '<=', 'NOW()')
    	->where('is_published', '=', true)
    	->orderBy('published_at', 'DESC')
    	->paginate(5);

    //vista
    return view('frontend.home', ['articles' => $articles, 'categories' => $categories]); 

});


Route::get('articolo/{slug}', function($slug) {

	$categories = \App\Category::all();
	$article = \App\Article::with('categories', 'user')
		->where('slug', '=', $slug)
		->first();

	return view('frontend.article', compact('categories', 'article'));
});


Route::get('autore/{slug}', function($slug){ 

	$categories = \App\Category::all(); 

	$author = \App\User::where('slug', '=', $slug)->first(); 

	$articles = $author->articles() //articles() cerca art. corrispondenti a $author
		->where('published_at', '<=', 'NOW()')
		->where('is_published', '=', true)
		->orderBy('published_at', 'DESC')
		->paginate(5); 

	return view('frontend.author', compact('categories', 'author', 'articles')); 

});


Route::get('categoria/{slug}', function($slug) { 

	$categories = \App\Category::all(); 

	$currentCategory = \App\Category::where('slug', '=', $slug)->first(); 

	$articles = $currentCategory->articles()  //articles() cerca art. corrispondenti a $currentCategory
		->where('published_at', '<=', 'NOW()')
		->where('is_published', '=', true)
		->orderBy('published_at', 'DESC')
		->paginate(5); 

	return view('frontend.category', compact('categories', 'currentCategory', 'articles')); 

});

*/

