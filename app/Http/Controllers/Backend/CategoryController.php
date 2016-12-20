<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function __construct() {

    	$this->middleware('auth');
        $this->middleware('admin')->only('add', 'add_post_method', 'edit', 'edit_post_method', 'delete');   // controllo --> solo gli admin accedono al metodo add, add_post_method, ecc..

    }


    public function index() {

    	$categories = Category::with('articles')->orderBy('created_at', 'DESC')->paginate(10);
    	return view('backend.category.list', compact('categories'));

    }


    public function add() {

    	return view('backend.category.add');

    }


    public function add_post_method(Request $request) {

    	$rules = [
    		'name' => 'required | max:30',
    		'description' => 'required | max:800',
    	];

    	$err_msg = [
    		'name.required' => 'Specificare il nome della categoria. Massimo 20 caratteri.',
    		'description.required' => 'Indicare una breve descrizione di massimo :max caratteri.',
    		'description.max' => 'La descrizione deve essere lunga non più di :max caratteri.',
    	];

    	$this->validate($request, $rules, $err_msg);

    	$category = new Category;

    	$category->name = $request->input('name');
    	$category->slug = Str::slug($category->name);
    	$category->description = $request->input('description');

    	$category->save();

    	return redirect('backend/categories')->with('success_message', 'Nuova categoria inserita correttamente..');

    }


    public function edit($categoryId) {

    	$category = Category::find($categoryId);
    	return view('backend.category.edit', compact('category'));

    }


    public function edit_post_method(Request $request, $categoryId) {

    	$rules = [
    		'name' => 'required', 
    		'description' => 'required',
    	];

    	$err_msg = [
    		'name.required' => "Specificare il nome.", 
    		'description.required' => "Specificare la descrizione.",
    	];

    	$this->validate($request, $rules, $err_msg);

    	$category = Category::find($categoryId);

    	$category->name = $request->input('name');
    	$category->slug = Str::slug($category->name);
    	$category->description = $request->input('description');

    	$category->save();

    	return redirect('/backend/categories/edit/' . $categoryId)->with('success_message', 'Categoria modificata con successo!<br><a href="/backend/categories">Torna alla lista delle categorie</a>');  //per stampare corretamente il link <a href=.."">..</a> --> nella view: sostituito {{ example }} con {!! example !!} (evita l'escape)

    }


    public function delete($categoryId) {

    	Category::find($categoryId)->delete();
    	return redirect('backend/categories')->with('success_message', 'Categoria cancellata con successo !');

    }





}
