<?php
namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Nombres
 *
 */
class Nombres extends Model
{

    use AutoTableTrait;

    protected $table = 'nombres';

}
