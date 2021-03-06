<?php

use Illuminate\Database\Seeder;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cr1 = ['name' => 'reguler', 'display_name' => 'Reguler', 'desc' => 'Reguler class'];
        $cr2 = ['name' => 'vip', 'display_name' => 'VIP', 'desc' => 'VIP class'];
        $cr3 = ['name' => 'vvip', 'display_name' => 'VVIP', 'desc' => 'VVIP class'];

        \Illuminate\Support\Facades\DB::table('class_rooms')->insert([$cr1, $cr2, $cr3]);


        $class1 = \App\ClassRoom::where('name', 'reguler')->first();
        $class2 = \App\ClassRoom::where('name', 'vip')->first();
        $class3 = \App\ClassRoom::where('name', 'vvip')->first();

        $room1 = ['name' => 'melati', 'display_name' => 'Kamar Melati', 'class_room_id' => $class1->id];
        $room2 = ['name' => 'anggrek', 'display_name' => 'Kamar Anggrek', 'class_room_id' => $class2->id];
        $room3 = ['name' => 'tulip', 'display_name' => 'Kamar Tulip', 'class_room_id' => $class3->id];

        \Illuminate\Support\Facades\DB::table('rooms')->insert([$room1, $room2, $room3]);


        $r1 = \App\Room::find(1);
        $r2 = \App\Room::find(2);
        $r3 = \App\Room::find(3);

        $b1 = ['name' => 'bed_1', 'display_name' => 'Bed 1', 'room_id' => $r1->id];
        $b2 = ['name' => 'bed_2', 'display_name' => 'Bed 2', 'room_id' => $r1->id];
        $b3 = ['name' => 'bed_3', 'display_name' => 'Bed 3', 'room_id' => $r1->id];
        $b4 = ['name' => 'bed_4', 'display_name' => 'Bed 4', 'room_id' => $r2->id];
        $b5 = ['name' => 'bed_5', 'display_name' => 'Bed 5', 'room_id' => $r2->id];
        $b6 = ['name' => 'bed_6', 'display_name' => 'Bed 6', 'room_id' => $r2->id];
        $b7 = ['name' => 'bed_7', 'display_name' => 'Bed 7', 'room_id' => $r3->id];
        $b8 = ['name' => 'bed_8', 'display_name' => 'Bed 8', 'room_id' => $r3->id];
        $b9 = ['name' => 'bed_9', 'display_name' => 'Bed 9', 'room_id' => $r3->id];

        \Illuminate\Support\Facades\DB::table('beds')->insert([$b1, $b2, $b3, $b4, $b5, $b6, $b7, $b8, $b9]);
    }
}
