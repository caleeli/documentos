<?php

namespace Tests\Feature;

use App\Derivacion;
use App\HojaRuta;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class HojaRutaTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        Auth::login($this->user);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // Crea hojas de ruta sin derivaciones
        $hojas = factory(HojaRuta::class, 25)->state('ejemplo')->create();
        // Assertion: hr_id es autoincrementable
        foreach ($hojas as $index => $hoja) {
            $this->assertEquals($index + 1, $hoja->getKey());
        }
        // Assertion: El usuario destinatario debe ser nulo
        foreach ($hojas as $index => $hoja) {
            $this->assertNull($hoja->usuario_destinatario);
        }

        // Crea hojas con derivacion
        $derivaciones = factory(Derivacion::class, 25)->state('ejemplo')->create([
            'destinatarios' => $this->user->getKey(),
        ]);
        // Assertion: El usuario destinatario debe ser el destinatario de la derivacion
        // Assertion: Estado PENDIENTE
        foreach ($derivaciones as $derivacion) {
            $this->assertEquals($this->user->getKey(), $derivacion->hoja_ruta->usuario_destinatario['id']);
            $this->assertEquals('PENDIENTE', $derivacion->hoja_ruta->estado);
        }

        // Crea hojas con derivacion y conclusion
        $derivacion = factory(Derivacion::class)->state('ejemplo')->create([
            'destinatarios' => $this->user->getKey(),
        ]);
        $derivacion->hoja_ruta->fecha_conclusion = $derivacion->hoja_ruta->fecha_recepcion;
        $derivacion->hoja_ruta->save();
        $this->assertEquals('CONCLUIDO', $derivacion->hoja_ruta->estado);
    }
}
