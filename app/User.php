<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'slug', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * Imposta le relazioni
     * Ogni User has_many articoli
     *
     */
    public function articles() {
        return $this->hasMany('App\Article');
    }


    /**
    * Imposta isAdmin method creato attraverso middleware
    *
    */
    public function isAdmin() {
        return $this->admin; // cerca la colonna admin nella tabella users
    }



    /**
     * metodo "mutator" --> anzichè criptare la password nel controller (nella singola request),
     * viene criptata direttamente nel model.
     * così ogni volta che si registra una nuova psw in user, viene criptata "di default"
     *
     */
    //public function setPasswordAttribute($value) {   //crea problemi: doppia criptazione con blog.app/register..
      //  $this->attributes['password'] = bcrypt($value);
    // }



}
