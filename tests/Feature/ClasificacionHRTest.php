<?php

namespace Tests\Feature;

use App\HojaRutaSubClases;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ClasificacionHRTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * Check hoja_ruta_sub_clases.
     *
     * @return void
     */
    public function testBasicTest()
    {
        Artisan::call('db:seed', ['--class' => 'SubClasificacionHojasRutaSeeder']);
        Artisan::call('db:seed', ['--class' => 'ClasificacionHojasRutaSeeder']);
        foreach (HojaRutaSubClases::all() as $sub) {
            preg_match_all('/[a-zÀ-ú]{4,}/i', $sub->nombre, $match);
            $sigla = '';
            $size = ceil(6 / count($match[0]));
            foreach ($match[0] as $ma) {
                $sigla .= mb_strtoupper(substr($ma, 0, $size));
            }
            $sub->sigla = $sigla;
            $this->assertGreaterThanOrEqual(4, strlen($sigla));
            $sub->save();
        }
    }
}
