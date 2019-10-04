<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Informe extends Model
{

    protected $table = 'informes';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('fecha_entrega', 'nombre_destinatario', 'referencia', 'archivo_adjunto', 'numero', 'gestion');
    protected $visible = array('fecha_entrega', 'nombre_destinatario', 'referencia', 'archivo_adjunto', 'numero', 'gestion');

    public function hojaRuta()
    {
        return $this->belongsTo('HojaRuta', 'ref_hoja_ruta');
    }
}
