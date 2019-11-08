<?php

use App\HojaRuta;
use App\Tarea;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CorregirTareasHr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarea_user', function (Blueprint $table) {
            $table->timestamp('fecha_conclusion')->nullable();
        });
        if (DB::connection()->getName() !== 'testing') {
            DB::select("SELECT setval('tarea_user_id_seq', max(id)) FROM tarea_user;");
        }
        // Unir tareas por HR
        $tareas = [];
        foreach (Tarea::all() as $tarea) {
            // Corrige asociacion HR y tarea
            $hoja = $tarea->derivacion && $tarea->derivacion->hoja_ruta ? $tarea->derivacion->hoja_ruta : HojaRuta::where('nro_de_control', $tarea->tar_codigo)->first();
            $tarea->hr_id = $hoja->getKey();
            $destinatarios = explode(',', $hoja->destinatario);
            foreach ($destinatarios as $destinatario) {
                if (!is_numeric($destinatario)) {
                    $destinatario = User::where(DB::raw("CONCAT(nombres, ' ', apellidos)"), '=', $destinatario)->first();
                    $destinatario = $destinatario ? $destinatario->getKey() : null;
                    if ($destinatario) {
                        break;
                    }
                } else {
                    break;
                }
            }
            $tarea->tar_creador_id = $destinatario;
            $tarea->save();
            // Corrige dias_plazo y fecha_registro de tarea_user
            foreach ($tarea->asignaciones as $asignacion) {
                $asignacion->fecha_conclusion = $tarea->tar_fecha_fin;
                foreach ($hoja->derivacion as $derivacion) {
                    $destinatarios = explode(',', $derivacion->destinatarios);
                    if (in_array($asignacion->user_id, $destinatarios)) {
                        $asignacion->dias_plazo = $derivacion->dias_plazo;
                        $asignacion->fecha_registro = $derivacion->fecha;
                    }
                }
                $asignacion->save();
            }
            // Une tareas
            $original = $tareas[$tarea->hr_id] ?? $tarea;
            if ($original !== $tarea) {
                if ($original->tar_estado != $tarea->tar_estado) {
                    $original->tar_estado = 'Pendiente';
                    $original->tar_fecha_fin = null;
                    $original->save();
                }
                $usuarios = $original->usuarios()->get();
                foreach ($tarea->asignaciones as $asignacion) {
                    $presente = false;
                    foreach ($usuarios as $usuario) {
                        $presente = $presente || ($asignacion->user_id == $usuario->getKey());
                    }
                    if (!$presente) {
                        $original->asignaciones()->create([
                            'user_id' => $asignacion->user_id,
                            'nro_asignacion' => $asignacion->nro_asignacion,
                            'dias_plazo' => $asignacion->dias_plazo,
                            'calificacion' => $asignacion->calificacion,
                            'fecha_conclusion' => $asignacion->fecha_conclusion,
                            'fecha_registro' => $asignacion->fecha_registro,
                            'fecha_modificacion' => $asignacion->fecha_modificacion,
                            'fecha_baja' => $asignacion->fecha_baja,
                            'user_add' => $asignacion->user_add,
                            'user_mod' => $asignacion->user_mod,
                            'user_del' => $asignacion->user_del,
                        ]);
                        $usuarios = $original->usuarios()->get();
                    }
                    foreach ($tarea->comentarios as $comentario) {
                        $comentario = $tarea->comentarios()->create([
                            'user_add' => $comentario->user_add,
                            'fecha_registro' => $comentario->fecha_registro,
                            'fecha_modificacion' => $comentario->fecha_modificacion,
                            'com_texto' => $comentario->com_texto,
                        ]);
                    }
                }
                $tarea->delete();
            } else {
                $tareas[$tarea->hr_id] = $original;
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarea_user', function (Blueprint $table) {
            $table->dropColumn(['fecha_conclusion']);
        });
    }
}
