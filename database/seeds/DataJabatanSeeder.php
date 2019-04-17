<?php

use Illuminate\Database\Seeder;

class DataJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataJabatans=[
            [
                'id' => 1,
                'nama_jabatan' => 'Direktur Utama',
            ],
            [
                'id' =>2,
                'nama_jabatan' => 'Wakil Direktur IT',
            ],
            [
                'nama_jabatan' => 'Kepala Bagian Coding',
                'id' =>3
            ],
            [
                'nama_jabatan' => 'Kepala Bagian Design',
                'id' =>4
            ],
            [
                'nama_jabatan' => 'Kepala Sub Bagian Coding PHP',
                'id' => 5
            ],
            [
                'nama_jabatan' => 'Kepala Sub Bagian Coding HTML',
                'id' => 6
            ],
            [
                'nama_jabatan' => 'Staf Coding PHP',
                'id' => 7
            ],
            [
                'nama_jabatan' => 'admin',
                'id' => 8
            ]
        ];
        DB::table('jabatans')->insert($dataJabatans);
    }
}
