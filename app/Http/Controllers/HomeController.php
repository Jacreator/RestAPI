<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * get user access token.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getToken()
    {
        return view('home.personal-tokens');
    }

    public function getClient()
    {
        # code...
        return view('home.personal-client');
    }

    public function getAuthorized()
    {
        # code...
        return view('home.authorize');
    }
}
