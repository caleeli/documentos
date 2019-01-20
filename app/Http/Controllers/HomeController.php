<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    use ListProcesses;

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
        $links = $this->listProcesses();
        return view('welcome', ['links' => $links]);
    }

    private function loadLinks()
    {
        $links = Auth::user()->links();
    }
}
