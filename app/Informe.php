<?php

namespace App;

use App\Traits\CorrelativoTrait;
use App\Traits\SaveUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Informe extends Model
{
    use SaveUserTrait;
    use SoftDeletes;
    use CorrelativoTrait;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $table = 'informes';
    protected $primaryKey = 'nro_inf_id';
    public $timestamps = true;
    protected $correlativos = [
        'nro_informe' => [],
    ];

    protected $dates = ['fecha_registro', 'fecha_modificacion', 'fecha_baja'];
    protected $guarded = [];
    protected $attributes = [
        'fecha_entrega' => '',
        'nombre_destinatario' => '',
        'nombre_remitente' => '',
        'referencia' => '',
        'ref_hoja_ruta' => '',
        'nro_informe' => null,
        'gestion' => '',
    ];

    public function hojaRuta()
    {
        return $this->belongsTo('HojaRuta', 'ref_hoja_ruta');
    }
}
