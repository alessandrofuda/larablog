<?php  // !!!!!!!!! dashboard del Backend !!!!!!!!!!

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;   // equivale a use Auth;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (Auth::user()->isAdmin()) {
            $rule = 'Amministratore';
        } else {
            $rule = 'Autore';
        }
        return view('backend.dashboard', compact('rule'));
    }

}
