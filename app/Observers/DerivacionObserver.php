<?php

namespace App\Observers;

use App\Derivacion;
use App\User;
use Illuminate\Support\Facades\DB;

class DerivacionObserver
{
    /**
     * Handle the derivacion "created" event.
     *
     * @param  \App\Derivacion  $derivacion
     * @return void
     */
    public function created(Derivacion $derivacion)
    {
        $creadorId = $this->creadorDerivacion($derivacion);
        $tarea = $derivacion->hoja_ruta->tarea;
        $tarea = $tarea ?: $derivacion->hoja_ruta->tarea()->create([
            'tar_codigo' => $derivacion->hoja_ruta->nro_de_control,
            'tar_descripcion' => $derivacion->hoja_ruta->referencia,
            'tar_fecha_derivacion' => $derivacion->fecha,
            'tar_prioridad' => 2,
            'tar_estado' => 'Pendiente',
            'tar_creador_id' => $creadorId,
        ]);
        $usuarios = $tarea->usuarios;
        $destinatarios = $derivacion->destinatarios ? explode(',', $derivacion->destinatarios) : [];
        foreach ($destinatarios as $i => $destinatario) {
            if (!is_numeric($destinatario)) {
                $destinatario = User::where(DB::raw("CONCAT(nombres, ' ', apellidos)"), '=', $destinatario)->first();
                $destinatarios[$i] = $destinatario ? $destinatario->getKey() : null;
            }
        }
        foreach ($usuarios as $usuario) {
            $index = array_search($usuario->getKey(), $destinatarios);
            if ($index !== false) {
                array_splice($destinatarios, $index, 1);
            }
        }
        foreach ($destinatarios as $destinatario) {
            $tarea->asignaciones()->create([
                'user_id' => $destinatario,
                'dias_plazo' => $derivacion->dias_plazo,
                'user_add' => $creadorId,
            ]);
        }
        //usuarios()->attach($destinatarios, ['dias_plazo' => $derivacion->dias_plazo]);
        $comentario = $tarea->comentarios()->create([
            'user_add' => $creadorId,
            'com_texto' => $derivacion->comentarios . ' - ' . $derivacion->instruccion,
        ]);
        //$comentario->user_add = $creadorId;
        //$comentario->save();
    }

    /**
     * Handle the derivacion "updated" event.
     *
     * @param  \App\Derivacion  $derivacion
     * @return void
     */
    public function updated(Derivacion $derivacion)
    {
        if ($derivacion->tarea) {
            $derivacion->tarea->tar_fecha_derivacion = $derivacion->fecha;
            $derivacion->tarea->tar_descripcion = $derivacion->comentarios;
            $derivacion->tarea->tar_creador_id = $this->creadorDerivacion($derivacion);
            $derivacion->tarea->usuarios()->sync(explode(',', $derivacion->destinatarios));
            $derivacion->tarea->save();
        } else {
            $this->created($derivacion);
        }
    }

    /**
     * Handle the derivacion "deleted" event.
     *
     * @param  \App\Derivacion  $derivacion
     * @return void
     */
    public function deleted(Derivacion $derivacion)
    {
        $derivacion->hoja_ruta->tarea->removeAssignment(explode(',', $derivacion->destinatarios));
    }

    /**
     * Handle the derivacion "restored" event.
     *
     * @param  \App\Derivacion  $derivacion
     * @return void
     */
    public function restored(Derivacion $derivacion)
    {
        $derivacion->tarea->restore();
    }

    /**
     * Handle the derivacion "force deleted" event.
     *
     * @param  \App\Derivacion  $derivacion
     * @return void
     */
    public function forceDeleted(Derivacion $derivacion)
    {
        //
    }

    private function creadorDerivacion(Derivacion $derivacion)
    {
        $destinatarios = $derivacion->hoja_ruta->destinatario ? explode(',', $derivacion->hoja_ruta->destinatario) : [];
        foreach ($destinatarios as $destinatario) {
            if (!is_numeric($destinatario)) {
                $destinatario = User::where(DB::raw("CONCAT(nombres, ' ', apellidos)"), '=', $destinatario)->first();
                $destinatario = $destinatario ? $destinatario->getKey() : null;
                if ($destinatario) {
                    return $destinatario;
                }
            } else {
                return $destinatario;
            }
        }
        return null;
    }
}
