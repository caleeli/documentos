<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Traits\SaveUserTrait;

class AdmFirma extends Model
{

    protected $table = 'adm_firmas';

}
