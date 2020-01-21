<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HojaRutaSubClases extends Model
{
    protected $primaryKey = 'sub_clase_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public function clasificacion()
    {
        return $this->belongsTo(HojaRutaClasificacion::class);
    }
}
