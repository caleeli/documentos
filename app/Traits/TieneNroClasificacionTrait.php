<?php

namespace App\Traits;

use App\HojaRuta;
use App\HojaRutaSubClases;
use Illuminate\Support\Facades\DB;

trait TieneNroClasificacionTrait
{
    public static function bootTieneNroClasificacionTrait()
    {
        static::saved([static::class, 'createNroClasificacion']);
        static::updating([static::class, 'updatingNroClasificacion']);
    }

    /**
     * Limpia nro_clasificacion si se cambia el subtipo_tarea
     *
     * @param HojaRuta $hoja
     * @return void
     */
    public static function updatingNroClasificacion(HojaRuta $hoja)
    {
        $changes = $hoja->getChanges();
        if (isset($changes['subtipo_tarea'])) {
            $this->nro_clasificacion = null;
        }
    }

    /**
     * Completa nro_clasificacion en las hojas de rutas
     *
     * @return void
     */
    public static function createNroClasificacion()
    {
        foreach (HojaRutaSubClases::all() as $sub) {
            $contador = HojaRuta::where('subtipo_tarea', $sub->sub_clase_id)->max('contador_clasificacion') ?: 1;
            foreach (HojaRuta::where('subtipo_tarea', $sub->sub_clase_id)->whereNull('nro_clasificacion')->orderBy('hr_id')->get() as $hoja) {
                DB::table('hoja_ruta')->where('hr_id', $hoja->getKey())->update([
                    'nro_clasificacion' => $sub->sigla . '-' . $contador,
                    'contador_clasificacion' => $contador,
                ]);
                $contador++;
            }
        }
    }
}
