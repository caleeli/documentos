<?php

namespace App;

use App\Traits\SaveUserTrait;
use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Area extends Model
{

    use SoftDeletes,
        Notifiable,
        SaveUserTrait;
    use AutoTableTrait;

    protected $table = 'adm_area';
    protected $fillable = [
        'area_id',
        'area_codigo',
        'area_descripcion'
    ];
    protected $attributes = array(
        'area_id' => '',
        'area_codigo' => '',
        'area_descripcion' => ''
    );
    protected $casts = array(
        'area_id' => 'string',
        'area_codigo' => 'string',
        'area_descripcion' => 'string'
    );
    protected $events = array(
    );

    
    public function area_desc()
    {
        $sql = "select area_descripcion from adm_area";
        $res = \DB::select($sql);
        return ["data" => $res];
    }
}
