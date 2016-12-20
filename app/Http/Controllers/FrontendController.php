<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{



    public function index() { 

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

    } 



    public function articolo($slug) { 

    	$categories = \App\Category::all();
		$article = \App\Article::with('categories', 'user')
			->where('slug', '=', $slug)
			->first();

		return view('frontend.article', compact('categories', 'article')); 

    } 



    public function autore($slug) { 

    	$categories = \App\Category::all(); 
		$author = \App\User::where('slug', '=', $slug)->first(); 
		$articles = $author->articles() //articles() cerca art. corrispondenti a $author
			->where('published_at', '<=', 'NOW()')
			->where('is_published', '=', true)
			->orderBy('published_at', 'DESC')
			->paginate(5); 

		return view('frontend.author', compact('categories', 'author', 'articles')); 

    } 



    public function categoria($slug) { 

    	$categories = \App\Category::all(); 
		$currentCategory = \App\Category::where('slug', '=', $slug)->first(); 
		$articles = $currentCategory->articles()  //articles() cerca art. corrispondenti a $currentCategory
			->where('published_at', '<=', 'NOW()')
			->where('is_published', '=', true)
			->orderBy('published_at', 'DESC')
			->paginate(5); 

		return view('frontend.category', compact('categories', 'currentCategory', 'articles')); 

    }
    
    
}
