<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class BackupController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            return view('backup');
        }
        return 'No tiene los privilegios requeridos';
    }

    public function download()
    {
        if (Auth::user()->role_id == 1) {
            header('Cache-Control: public'); // needed for internet explorer
            header('Content-Type: application/x-bak');
            header('Content-Transfer-Encoding: Binary');
            header('Content-Disposition: attachment; filename=hrlegal.bak');
            Artisan::call('backup:data');
        } else {
            return 'No tiene los privilegios requeridos';
        }
    }
}
