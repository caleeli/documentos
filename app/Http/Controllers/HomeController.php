<?php

namespace App\Http\Controllers;

use App\Process;
use Illuminate\Support\Facades\Auth;
use ProcessMaker\Nayra\Contracts\Bpmn\ActivityInterface;

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
        /*$tasks = [];
        $processes = Process::where('status', 'ACTIVE')->get();
        foreach ($processes as $process) {
            foreach ($process->tokens as $key => $token) {
                if ($token['status'] === ActivityInterface::TOKEN_STATE_ACTIVE) {
                    $task = [
                        'icon' => '/images/carpeta.svg',
                        'text' => $token['name'],
                    ];
                    if ($token['module']) {
                        $task['href'] = $token['module'] . '?instanceId=' . $process->id
                            . '&elementId=' . $token['elementId']
                            . '&tokenId=' . $key;
                    } else {
                        $task['macro'] = [
                            'macro' => 'completeTask',
                            'instanceId' => $process->id,
                            'elementId' => $token['elementId'],
                            'tokenId' => $key,
                        ];
                    }
                    $tasks[] = $task;
                }
            }
        }*/
        $links = $this->listProcesses();
        return view('welcome', ['links' => $links]);
    }

    private function loadLinks()
    {
        $links = Auth::user()->links();
    }
}
