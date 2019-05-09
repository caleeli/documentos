<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Module;

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
        $links = $this->listModules();
        foreach($this->listProcesses() as $key => $value) {
            $links[$key] = $value;
        }
        return view('welcome', ['links' => $links]);
    }

    private function loadLinks()
    {
        $links = Auth::user()->links();
    }

    private function listModules()
    {
        $links = [];
        foreach(Module::where('parent', 0)->get() as $module) {
            $link = [
                'text' => $module->name,
                'icon' => $module->icon,
                'description' => $module->description,
                'href' => $module->route,
            ];
            foreach (Module::where('parent', $module->id)->get() as $submodule) {
                $link['links'][] = [
                    'text' => $submodule->name,
                    'icon' => $submodule->icon,
                    'description' => $submodule->description,
                    'href' => $submodule->route,
                ];
            }
            $links[$module->id] = $link;
        }
        return $links;
    }
}
