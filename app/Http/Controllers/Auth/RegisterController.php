<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewSubscriberNotification;




class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/backend'; // sostituito /home con /backend

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255', 
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ], [
            'first_name.required' => 'Inserisci il tuo nome',
            'last_name.required' => 'Inserisci il tuo cognome',
            'email.required' => 'Inserisci una mail valida',
            'email.unique' => 'La mail inserita è già presente nel nostro database!',
            'password.required' => 'Inserire una password',
            'password.min' => 'La password deve avere almeno :min caratteri',
            'password.confirmed' => 'Errore di validazione password',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {   
        // notifica mail all'admin
        Mail::to('alessandro.fuda@gmail.com', 'Larablog Admin')->send(new NewSubscriberNotification($data));
        //dd('mail inviata');

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'slug' => str_slug($data['first_name'].'-'.$data['last_name']), //controllare validazione accenti, apostrofi, maiuscole/minuscole, ecc...
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

    }
}
