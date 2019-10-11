<?php

namespace App;

use App\Rules\UntilToday;
use App\Traits\AutoTableTrait;
use App\Traits\ValidatedModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of Derivacion
 *
 */
class Derivacion extends Model
{
    use SoftDeletes;
    use AutoTableTrait;
    use ValidatedModelTrait;

    public $timestamps = false;
    protected $table = 'derivacion';
    protected $fillable = [
        'fecha',
        'comentarios',
        'destinatario',
        'destinatarios',
        'instruccion',
        'dias_plazo',
        'hoja_ruta_id',
        'firma',
    ];
    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Reglas de validacion para la derivacion.
     *
     * @return array
     */
    protected function getRules()
    {
        $rules = [
            //'comentarios' => ['required'],
            'destinatarios' => ['required'],
        ];
        $rules['fecha'][] = new UntilToday();
        return $rules;
    }

    public function hoja_ruta()
    {
        return $this->belongsTo(HojaRuta::class, 'hoja_ruta_id', 'hr_id');
    }

    public function tarea()
    {
        return $this->hasOne(Tarea::class, 'derhr_id');
    }

    public function setDestinatariosAttribute($value)
    {
        if ($value) {
            $this->attributes['destinatario'] = implode(', ', User::findMany(explode(',', $value))->pluck('nombre_completo')->toArray());
        }
        $this->attributes['destinatarios'] = $value;
    }
}
