<?php
namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Description of Nombres
 *
 */
class Nombres extends Model
{

    use AutoTableTrait;

    protected $table = 'nombres';

}
