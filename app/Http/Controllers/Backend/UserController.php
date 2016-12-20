<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;  //aggiunto per chiamare la classe Str::slug
use App\User;
use App\Http\Middleware\Admin;

class UserController extends Controller
{

    public function __construct() {

    	$this->middleware('auth');   // controllo--> solo user autenticati accedono a questi metodi
        $this->middleware('admin')->only('add', 'add_with_post_method', 'edit', 'edit_post', 'delete');   // controllo --> solo gli admin accedono al metodo add, add_with_post_method, delete

    }


    public function index() {
    	
    	$users = \App\User::orderBy('created_at', 'DESC')->paginate(10); 
        
    	return view('backend.user.list', compact('users')); 
    }


    public function add() {

    	return view('backend.user.add');

    }



    public function add_with_post_method(Request $request) {

    	$rules = [
    		'first_name' => 'required | max:255',
    		'last_name' => 'required | max:255',
    		'email' => 'required | email | max:255 | unique:users',
    		'password' => 'required | min:3 | confirmed',
    	];

    	$messages = [
    		'first_name.required' => 'Indicare il nome.',
    		'first_name.max' => 'Il nome indicato è troppo lungo.',
    		'last_name.required' => 'Indicare il cognome.',
    		'last_name.max' => 'Il cognome indicato è troppo lungo.',
    		'email.required' => 'Indicare un indirizzo email.',
    		'email.email' => 'Inserisci un indirizzo email valido.',
    		'email.unique' => 'L\'indirizzo email indicato esiste già. Prova con un altro!',
    		'password.required' => 'La password è obbligatoria.',
    		'password.min' => 'Inserire una password di almeno :min caratteri.',
    		'password.confirmed' => 'Le due Password inserite non coincidono.',
    	];

    	$this->validate($request, $rules, $messages);
    	

    	$user = new User;  // nuovo utente

    	$user->first_name = $request->input('first_name');
    	$user->last_name = $request->input('last_name');
    	$user->slug = Str::slug($user->first_name.$user->last_name);  
    	$user->email = $request->input('email');
    	$user->password = bcrypt($request->input('password')); 

    	$user->save();

    	return redirect('backend/users')->with('success_message', 'Nuovo utente inserito correttamente!');

    }



    public function edit($id) {

        $user = User::find($id);
        return view('backend.user.edit', compact('user'));

    }



    public function edit_post(Request $request, $id) {

        $rules = [
            'first_name' => 'required | max:255',
            'last_name' => 'required | max:255',
            'email' => 'required | email | max:255 | unique:users,email,' . $id,   // !!! $id --> EXCEPTION!! evita che l'invio della stessa mail 
                                                                                    // già presente in db dia errore di validazione
        ];

        $messages = [
            'first_name.required' => 'Indicare il nome.',
            'first_name.max' => 'Il nome indicato è troppo lungo.',
            'last_name.required' => 'Indicare il cognome.',
            'last_name.max' => 'Il cognome indicato è troppo lungo.',
            'email.required' => 'Indicare un indirizzo email.',
            'email.email' => 'Inserisci un indirizzo email valido.',
            'email.unique' => 'L\'indirizzo email indicato esiste già. Prova con un altro!',  
         ];

        $this->validate($request, $rules, $messages);


        $user = User::find($id);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        if ( !empty(trim($request->input('password'))) ) {  // TRIMM !!

            $user->password = bcrypt($request->input('password'));

        }

        $checkbox = $request->input('admin-rule');
        // $user->admin = $request->input('admin-rule');

        if ($checkbox === "administrator")

            $user->admin = 1;

        else

            $user->admin = 0;

        $user->save();

        return redirect('backend/users')->with('success_message', 'Profilo utente modificato correttamente!');


    }




    public function delete($userId) {

    	User::find($userId)->delete();
		return redirect('backend/users')->with('success_message', 'Utente eliminato correttamente!');
    }





    //operazioni relative al my_profile (mostra mio profilo, modifica mio profilo)

    public function myprofile() {
 
    	return view('backend.user.myprofile');

    }


    public function update_my_prof() {

    	return view('backend.user.myprofile_update');

    }


    public function update_my_prof_post_method(Request $request) {

    	$id = Auth::user()->id; 

    	$rules = [
    		'first_name' => 'required | max:255',
    		'last_name' => 'required | max:255',
    		'email' => 'required | email | max:255 | unique:users,email,'. $id, // !!! ID --> EXCEPTION!!
    		'password' => 'min:3 | confirmed', //tolto 'required'
    	];

    	$messages = [
    		'first_name.required' => 'Indicare il nome.',
    		'first_name.max' => 'Il nome indicato è troppo lungo.',
    		'last_name.required' => 'Indicare il cognome.',
    		'last_name.max' => 'Il cognome indicato è troppo lungo.',
    		'email.required' => 'Indicare un indirizzo email.',
    		'email.email' => 'Inserisci un indirizzo email valido.',
    		'email.unique' => 'L\'indirizzo email indicato esiste già. Prova con un altro!',
    		// 'password.required' => 'La password è obbligatoria.',
    		'password.min' => 'Inserire una password di almeno :min caratteri.',
    		'password.confirmed' => 'Le due Password inserite non coincidono.',
    	];

    	$this->validate($request, $rules, $messages);
    	

    	$user = User::find($id);   


    	$user->first_name = $request->input('first_name');
    	$user->last_name = $request->input('last_name');
    	$user->slug = Str::slug($user->first_name.$user->last_name);
    	$user->email = $request->input('email');

    	if(isset($_POST['password']) && !empty(trim($_POST['password']))) {   

    		$user->password = bcrypt($request->input('password'));

    	}

    	$user->save();

    	return redirect('backend/myprofile')->with('success_message', 'Utente modificato correttamente!');

    }


    public function delete_my_prof_post_method(Request $request)
    {
        $myId = Auth::user()->id; 

        $rules = [
            '_token' => 'required',
        ];

        $this->validate($request, $rules);

        User::find($myId)->delete();
        return redirect('backend/users')->with('success_message', 'Il tuo profilo è stato eliminato!');

    }


}
