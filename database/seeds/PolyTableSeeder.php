<?php

use Illuminate\Database\Seeder;

class PolyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $poli_umum = ['name' => 'Poli Umum', 'desc' => 'Poli Umum'];
        $poli_kebidanan = ['name' => 'Poli Kebidanan', 'desc' => 'Poli Kebidanan'];
        $poli_anak = ['name' => 'Poli Anak', 'desc' => 'Poli Anak'];
        $poli_gigi = ['name' => 'Poli Gigi', 'desc' => 'Poli Gigi'];
        $poli_penyakit_dalam = ['name' => 'Poli Spesialis Penyakit Dalam', 'desc' => 'Poli Spesialis Penyakit Dalam'];
        $poli_mata = ['name' => 'Poli Mata', 'desc' => 'Poli Mata'];
        $poli_tht = ['name' => 'Poli THT', 'desc' => 'Poli THT'];
        $poli_bedah = ['name' => 'Poli Bedah', 'desc' => 'Poli Bedah'];

        \Illuminate\Support\Facades\DB::table('polies')->insert([$poli_umum, $poli_kebidanan, $poli_anak, $poli_gigi, $poli_penyakit_dalam, $poli_mata, $poli_tht, $poli_bedah]);
    }
}
