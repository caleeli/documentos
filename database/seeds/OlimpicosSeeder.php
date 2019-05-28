<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OimpicosSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->onlyOnce()) {
            return;
        }
        DB::connection('hr')
            ->table('hoja_ruta_sub_clases')
            ->insert([
                [
                    'id' => 1,
                    'name' => 'Zeus',
                    'avatar' => '',
                ],
        ]);
    }

    private function onlyOnce()
    {
        return DB::connection('hr')
                ->table('olimpicos')
                ->where('id', 1)
                ->first();
    }
}
