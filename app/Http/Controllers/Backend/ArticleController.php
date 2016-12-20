<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Article;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\ArticlePostedForReview;

class ArticleController extends Controller
{



    public function __construct() {

    	$this->middleware('auth');
        $this->middleware('admin')->only('index');   // /* 'delete_with_post_method', 'update', 'update_with_post_method', */  controllo --> solo gli admin accedono a questi  metodi..

    }




    public function index() {  //chi accede? SOLO admin !

    	$articles = Article::with('user', 'categories')->orderBy('published_at', 'DESC')->paginate(10); // with() --> è un Eager Loading. Significa: 
    	return view('backend.article.list', compact('articles'));										// preleva tutti gli articoli CON i relativi autori (users) e
    																									// categorie come da relazioni definite nei rispettivi Model

    }




    public function add() {  //chi accede? sia Admin sia Author, ma Author NON può pubblicare articoli

    	$categories = Category::all();
        Auth::user()->isAdmin() ? $notice = null : $notice = 'title="Solo l\'Admin può pubblicare un articolo"';
        Auth::user()->isAdmin() ? $disabled = null : $disabled = 'disabled';
        Auth::user()->isAdmin() ? $button = 'Salva/pubblica articolo' : $button = 'Invia all\'Admin per la revisione';

    	return view('backend.article.add', compact('categories', 'notice', 'disabled', 'button' ));
    	
    }




    public function add_post_method(Request $request) {    //chi accede? sia Admin sia Author

    	$rules = [
    		'title' => 'required',
    		'body' => 'required',
    		'published_at' => 'required | date_format:d/m/Y H:i',
    	];

    	$err_msg = [
    		'title.required' => 'specificare un titolo all\'articolo',
    		'body.required' => 'Il testo dell\'articolo non può essere vuoto',
    		'published_at.required' => 'Specificare la data di publicazione.', 
    		'published_at.date_format' => 'La data di pubblicazione deve essere nel formato gg/mm/aaaa hh:mm',
    	];

    	$this->validate($request, $rules, $err_msg);
    	
    	$article = new Article;

    	$article->title = $request->get('title');
    	$article->slug = Str::slug($article->title);
    	$article->body = $request->get('body');

        if ( Auth::user()->isAdmin() ) {
            $article->is_published = $request->get('is_published');
            //dd($request->get('is_published'));
        } else {
            // dd($request->get('is_published'));
            $article->is_published = 0;  // se non sei admin salva SEMPRE l'articolo in db come bozza.
        }
    	

    	$date = \DateTime::createFromFormat('d/m/Y H:i', $request->get('published_at')); // converte da stringa a formato data.
    	$article->published_at = $date->format('Y-m-d H:i');  // converte in data "formato standard" del db

    	$article->meta_keys = $request->get('metakeys');
    	$article->meta_description = $request->get('metadescription');
    	$article->user_id = Auth::user()->id;

    	$article->save();

    	$article->categories()->sync($request->get('categories')); // con sync() è possibile passsare un array (id delle categorie) alla tabella article_category

        if ( Auth::user()->isAdmin() ) {

    	   return redirect('backend/articles')->with('success_message', 'Articolo aggiunto correttamente.');

        } else {


            if ($request->get('salva_e_invia')) {
                //dd('OK - Mail');
                //  NOTIFICA MAIL ALL'ADMIN !!!!!!!!!!!!!!
                Mail::to('alessandro.fuda@gmail.com')->send(new ArticlePostedForReview($article)); //per TESTING --> in /config/mail.php settare 'driver' a 'log'
                $save_and_send = true;

            } else {

                $save_and_send = false;

            }

            if ($save_and_send) {

                return redirect('backend/my-articles')->with('success_message', 'Articolo inviato all\'Amministratore per la revisione.<br>Dopo l\'approvazione verrà pubblicato.');

            } else {

                return redirect('backend/my-articles')->with('success_message', 'Articolo salvato correttamente.');

            } 

        }


    }




    public function update($articleId) {        //chi accede? sia Admin sia Author, ma filtrando solo gli $articleId appartenenti all'autore autenticato
                                                // (perchè altrimenti un Author potrebbe editare articoli di altri)

    	$categories = Category::all();
        $article = Article::find($articleId);


        if ( Auth::user()->isAdmin() || ($article->user_id === Auth::user()->id && $article->is_published === 0) ) {

            Auth::user()->isAdmin() ? $disabled = '' : $disabled = 'disabled';
            Auth::user()->isAdmin() ? $notice = 'Modifica qui lo stato dell\'articolo' : $notice = 'Solo l\'Admin può modificare lo Stato dell\'articolo!';        
            
            return view('backend.article.edit', compact('categories', 'article', 'disabled', 'notice'));

        } else {

            return redirect('backend/my-articles')->with('error_message', 'Per editare questo articolo devi esserne il proprietario o un Amministratore');
        }

    	
    }




    public function update_with_post_method(Request $request, $articleId) {         //chi accede? sia Admin che Author, ma filtrando come sopra

        $article = Article::find($articleId);

        if(!Auth::user()->isAdmin() && $article->user_id != Auth::user()->id ) {

            return redirect('backend/my-articles')->with('error_message', 'Per inviare questo articolo devi esserne il proprietario o un Amministratore');

        } else {

        	$rules = [
        		'title' => 'required',
        		'body' => 'required',
        		'published_at' => 'required | date_format:d/m/Y H:i',
        	];

        	$err_msg = [
        		'title.required' => 'Inserire un titolo per l\'articolo',
        		'body.required' => 'Inserire il testo dell\'articolo',
        		'published_at.required' => 'Inserire la data di pubblicazione',
        		'published_at.date_format' => 'Specificare la data col giusto formato: gg/mm/aaaa hh:mm',
        	];

        	$this->validate($request, $rules, $err_msg);

        	$article = Article::find($articleId);

        	$article->title = $request->get('title');
        	$article->slug = Str::slug($article->title);
        	$article->body = $request->get('body');

            if ( Auth::user()->isAdmin() ) {

                $article->is_published = $request->get('is_published');

            } else {

                $article->is_published = 0;  // se NON sei admin --> l'articolo è salvato sempre in bozza.
            }
        	

        	$date = \DateTime::createFromFormat('d/m/Y H:i', $request->get('published_at')); 
        	$article->published_at = $date->format('Y-m-d H:i'); // in db inserisco la data con formato standard yyyy/mm/dd hh:mm

        	$article->meta_keys = $request->get('metakeys'); 
        	$article->meta_description = $request->get('metadescription'); 

        	$article->save(); 

        	$article->categories()->sync($request->get('categories')); //estrae gli Id delle categorie associate all'articolo (un array) e le passa tramite sync.



            // LOGICA CHE DIFFERENZIA I DUE BUTTONS
            if($request->get('save_and_send')) {
                
                Mail::to('alessandro.fuda@gmail.com')->send(new ArticlePostedForReview($article)); //per il TESTING --> settare il driver a 'log' in /config/mail.php
                $save_and_send = true;

            }  else {
                
                $save_and_send = false;
            }


            Auth::user()->isAdmin() ? $return = 'articles' : $return = 'my-articles';

            if ($save_and_send) {

                return redirect('backend/articles/edit/' . $articleId)->with('success_message', 'Articolo salvato e inviato per la revisione. <a href="/backend/' . $return . '">Torna alla lista degli articoli</a>');

            } else {

        	   return redirect('backend/articles/edit/' . $articleId)->with('success_message', 'Articolo modificato correttamente. <a href="/backend/' . $return . '">Torna alla lista degli articoli</a>');
            }

        }

    }


    public function delete_with_post_method($articleId) {           //chi accede? Admin, e Author SOLO SE l'articolo è il PROPRIO non è pubblicato

        $article = Article::find($articleId); 

        if (Auth::user()->isAdmin())
            $return = 'articles';
        else 
            $return = 'my-articles';
        



        if ( Auth::user()->isAdmin() ) {

            // $article->delete();  // TESTING
            return redirect('backend/'.$return)->with('success_message', 'Articolo cancellato con successo!');            

        } else {  // if is author...

            if ( Auth::user()->id === $article->user_id && $article->is_published === 0) {

                // $article->delete();  // TESTING
                return redirect('backend/'.$return)->with('success_message', 'Articolo cancellato con successo!');

            } else {

                return redirect('backend/'.$return)->with('error_message', 'Come Autore puoi cancellare solo articoli scritti da te e NON già pubblicati');

            }

        }

    	
    	
    }









    public function my_articles() {         //chi accede? Sia Admin sia Author autenticato

        $current_user_id = Auth::user()->id;  // 2;

        $articles = Article::with('user', 'categories')                     // with() method è un Eager Loading--> vedi sopra in index method
                        ->where('user_id', $current_user_id)
                        ->orderBy('published_at', 'DESC')
                        ->paginate(10);  


        return view('backend.article.list', compact('articles'));   
    }



}
