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
        $user = Auth::user();
        $links = [];
        $where = Module::where('parent', 0);
        $where = $user->role_id == '2' ? $where->where('id', '!=', '900') : $where;
        foreach($where->get() as $module) {
            $link = [
                'text' => $module->name,
                'icon' => $module->icon,
                'description' => $module->description,
                'href' => $module->route,
            ];
            $where = Module::where('parent', $module->id);
            $where = $user->role_id == '3' ? $where->where('name', '!=', 'Registrar') : $where;
            foreach ($where->get() as $submodule) {
                $link['links'][] = [
                    'text' => $submodule->name,
                    'icon' => $submodule->icon,
                    'description' => $submodule->description,
                    'href' => $submodule->route,
                ];
            }
            $links[$module->id] = $link;
        }
        if ($user->role_id == 1) {
            $links = $this->addNewReports($links);
        }
        return $links;
    }

    public function addNewReports($links)
    {
        $links['1200'] = [
            'text' => 'Nuevos Reportes',
            'icon' => '/images/reporte.svg',
            'description' => 'Nuevos Reportes de hojas de ruta, notas, etc.',
            'href' => '/?item=1200',
            'links' => [
                [
                    'text' => 'Cantidad de Hojas de Ruta',
                    'description' => 'Registrados en un periodo de tiempo',
                    'icon' => '/images/reporte.svg',
                    'href' => '/reporte1/registrados',
                ],
                [
                    'text' => 'Cantidad de Hojas de Ruta',
                    'description' => 'Concluidas en un periodo de tiempo',
                    'icon' => '/images/reporte.svg',
                    'href' => '/reporte1/concluidas',
                ],
                [
                    'text' => 'Cantidad de Tareas',
                    'description' => 'Asignadas en un periodo de tiempo',
                    'icon' => '/images/reporte.svg',
                    'href' => '/reporte1/tareas/asignadas',
                ],
                [
                    'text' => 'Cantidad de Tareas',
                    'description' => 'Concluidas en un periodo de tiempo',
                    'icon' => '/images/reporte.svg',
                    'href' => '/reporte1/tareas/concluidas',
                ],
            ],
        ];
        return $links;
    }
}
