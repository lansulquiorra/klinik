<?php

use Illuminate\Database\Seeder;

class PermsRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*role*/
        $r1 = \App\Role::where('name', 'admin')->first();
        $r2 = \App\Role::where('name', 'loket')->first();
        $r3 = \App\Role::where('name', 'admin_loket')->first();
        $r4 = \App\Role::where('name', 'poli_umum')->first();
        $r5 = \App\Role::where('name', 'admin_poli_umum')->first();
        $r6 = \App\Role::where('name', 'poli_anak')->first();
        $r7 = \App\Role::where('name', 'admin_poli_anak')->first();
        $r8 = \App\Role::where('name', 'kasir')->first();
        $r9 = \App\Role::where('name', 'admin_kasir')->first();
        $r10 = \App\Role::where('name', 'apotek')->first();
        $r11 = \App\Role::where('name', 'admin_apotek')->first();
        $r12 = \App\Role::where('name', 'penata_jasa')->first();
        $r13 = \App\Role::where('name', 'poli_gigi')->first();

        /*perms*/
        $p1 = \App\Permission::where('name', 'loket')->first();
        $p2 = \App\Permission::where('name', 'kasir')->first();
        $p3 = \App\Permission::where('name', 'penata_jasa')->first();
        $p4 = \App\Permission::where('name', 'apotek')->first();
        $p5 = \App\Permission::where('name', 'poly_umum')->first();
        $p6 = \App\Permission::where('name', 'poli_anak')->first();
        $p7 = \App\Permission::where('name', 'poli_gigi')->first();
        $p8 = \App\Permission::where('name', 'data_patient')->first();
        $p9 = \App\Permission::where('name', 'master_data')->first();
        $p10 = \App\Permission::where('name', 'rawat_inap')->first();
        $p11 = \App\Permission::where('name', 'laboratorium')->first();
        $p12 = \App\Permission::where('name', 'radiologi')->first();


        $r1->attachPermissions(array($p1, $p2, $p3, $p4, $p8, $p9, $p10, $p11, $p12));
        $r2->attachPermissions(array($p1, $p8));
        $r3->attachPermissions(array($p1, $p8));
        $r4->attachPermissions(array($p5, $p8));
        $r5->attachPermissions(array($p5, $p8));
        $r6->attachPermissions(array($p6, $p8));
        $r7->attachPermissions(array($p6, $p8));
        $r8->attachPermissions(array($p2, $p8));
        $r9->attachPermissions(array($p2, $p8));
        $r10->attachPermissions(array($p4, $p8));
        $r11->attachPermissions(array($p4, $p8));
        $r12->attachPermissions(array($p3, $p8));
        $r13->attachPermissions(array($p7, $p8));
    }
}
