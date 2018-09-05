<?php
namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Documentos
 *
 */
class Documentos extends Model
{

    use AutoTableTrait;

    protected $table = 'documentos';

}
