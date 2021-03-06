<?php

use Illuminate\Database\Seeder;

class StaffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sp_direktur = ['name' => 'Direktur', 'desc' => 'Direktur'];
        $sp_wakil = ['name' => 'Wakil', 'desc' => 'Wakil Direktur'];
        $sp_ketua_bedah = ['name' => 'Ketua Dokter Bedah', 'desc' => 'Ketua Dokter Bedah'];
        $sp_ketua_ugd = ['name' => 'Ketua UGD', 'desc' => 'Ketua UGD'];
        $sp_ketua_umum = ['name' => 'Ketua Umum', 'desc' => 'Ketua Umum'];

        \Illuminate\Support\Facades\DB::table('staff_positions')->insert([$sp_direktur, $sp_wakil, $sp_ketua_bedah, $sp_ketua_ugd, $sp_ketua_umum]);

        $direktur = \App\StaffPosition::where('name', 'Direktur')->first();
        $wakil = \App\StaffPosition::where('name', 'Wakil')->first();
        $ketua_dokter_bedah = \App\StaffPosition::where('name', 'Ketua Dokter Bedah')->first();
        $ketua_UGD = \App\StaffPosition::where('name', 'Ketua UGD')->first();
        $ketua_umum = \App\StaffPosition::where('name', 'Ketua Umum')->first();

        $user_1 = \App\User::where('username', 'admin')->first();
        $user_2 = \App\User::where('username', 'loket')->first();
        $user_3 = \App\User::where('username', 'poli_umum')->first();
        $user_4 = \App\User::where('username', 'poli_anak')->first();
        $user_5 = \App\User::where('username', 'kasir')->first();

        $job_dokter = \App\StaffJob::where('name', 'Dokter')->first();


        $alan = ['nik' => '11111', 'full_name' => 'Alan', 'gender' => 1, 'staff_job_id' => $job_dokter->id, 'hospital_id' => 1, 'user_id' => $user_1->id, 'staff_position_id' => $direktur->id];
        $syahril = ['nik' => '22222', 'full_name' => 'Syahril', 'gender' => 1, 'staff_job_id' => $job_dokter->id, 'hospital_id' => 1, 'user_id' => $user_2->id, 'staff_position_id' => $wakil->id];
        $lucky = ['nik' => '33333', 'full_name' => 'Lucky', 'gender' => 1, 'staff_job_id' => $job_dokter->id, 'hospital_id' => 1, 'user_id' => $user_3->id, 'staff_position_id' => $ketua_dokter_bedah->id];
        $user_4 = ['nik' => '4444', 'full_name' => 'Ismanto', 'gender' => 1 , 'staff_job_id' => $job_dokter->id, 'hospital_id' => 1, 'user_id' => $user_4->id, 'staff_position_id' => $ketua_UGD->id];
        $user_5 = ['nik' => '5555', 'full_name' => 'Risa', 'gender' => 2 , 'staff_job_id' => $job_dokter->id, 'hospital_id' => 1, 'user_id' => $user_5->id, 'staff_position_id' => $ketua_umum->id];

        \Illuminate\Support\Facades\DB::table('staff')->insert([$alan, $syahril, $lucky, $user_4, $user_5]);
    }
}
