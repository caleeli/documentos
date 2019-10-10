<?php

namespace App\Observers;

use App\Derivacion;

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
        $tarea = $derivacion->tarea()->create([
            'tar_codigo' => $derivacion->hoja_ruta->nro_de_control,
            'tar_descripcion' => $derivacion->comentarios . ' - ' . $derivacion->instruccion,
            'tar_fecha_derivacion' => $derivacion->fecha,
            'tar_prioridad' => 2,
            'tar_estado' => 'Pendiente',
            'tar_creador_id' => $this->creadorDerivacion($derivacion),
        ]);
        $tarea->usuarios()->sync(explode(',', $derivacion->destinatarios));
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
        $derivacion->tarea->delete();
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
        $destinatarios = $derivacion->hoja_ruta->derivacion()->first()->destinatarios;
        return $destinatarios ? explode(',', $destinatarios)[0] : null;
    }
}
