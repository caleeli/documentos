<?php

namespace App;

use App\Traits\AutoTableTrait;
use App\Traits\CorrelativoTrait;
use App\Traits\ValidatedModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Notas oficio
 *
 */
class NotasOficio extends Model
{
    use CorrelativoTrait;
    use AutoTableTrait;
    use ValidatedModelTrait;

    protected $table = 'notas_oficio';
    protected $correlativos = [
        'nro_nota' => [],
    ];

    public $timestamps = false;
    protected $fillable = [
        'hoja_de_ruta',
        'fecha_emision',
        'nro_nota',
        'reiterativa',
        'fecha_entrega',
        'entidad_empresa',
        'nombre_apellidos',
        'cargo',
        'referencia',
        'dias',
        'retraso',
        'observaciones',
        'hoja_de_ruta_recepcion',
        'fecha_recepcion',
        'nro_nota_recepcion',
        'remitente_recepcion',
        'referencia_recepcion',
        'fojas_recepcion',
        'gestion',
    ];
    protected $appends = [
    ];
    protected $dispatchesEvents = [
        //'creating' => [self::class, 'creatingNota'],
    ];

    public function getRules()
    {
        return [
            'hoja_de_ruta' => ['required'],
            'fecha_emision' => ['required'],
            'reiterativa' => ['required'],
            'fecha_entrega' => ['required'],
            'entidad_empresa' => ['required'],
            'nombre_apellidos' => ['required'],
            'cargo' => ['required'],
            'referencia' => ['required'],
            //'dias' => ['required'],
            //'retraso' => ['required'],
            ///'hoja_de_ruta_recepcion' => ['required'],
            ///'fecha_recepcion' => ['required'],
            ///'nro_nota_recepcion' => ['required'],
            ///'remitente_recepcion' => ['required'],
            ///'referencia_recepcion' => ['required'],
            //'fojas_recepcion' => ['required'],
            'gestion' => ['required'],
        ];
    }
}
