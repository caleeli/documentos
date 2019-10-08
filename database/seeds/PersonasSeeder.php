<?php

use App\Persona;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class PersonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::login(User::find(1));
        factory(Persona::class, 15)->create();
    }
}
