<?php

use Illuminate\Database\Seeder;

class DataAwalPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataUsers =[
            [
                'id' => 1,
                'username' => 'andi',
                'password' => bcrypt('123456'),
                'nama_jabatan' => 1,
                'email' => Str::random(10).'@gmail.com',
                'role' => 'direktur',
                'atasan_id' => null,
                'name' => 'Andi'
            ],
            [
                'id' => 2,
                'username' => 'budi',
                'password' => bcrypt('123456'),
                'nama_jabatan' => 2,
                'email' => Str::random(10).'@gmail.com',
                'role' => 'wakil_direktur',
                'atasan_id' => '1',
                'name' => 'Budi'
            ],
            [
                'id' => 3,
                'username' => 'cici',
                'password' => bcrypt('123456'),
                'nama_jabatan' => 3,
                'email' => Str::random(10).'@gmail.com',
                'role' => 'kepala_bagian',
                'atasan_id' => '2',
                'name' => 'Cici'
            ],
            [
                'id' => 4,
                'username' => 'dini',
                'password' => bcrypt('123456'),
                'nama_jabatan' => 4,
                'email' => Str::random(10).'@gmail.com',
                'role' => 'kepala_bagian',
                'atasan_id' => '2',
                'name' => 'Dini'
            ],
            [
                'id' => 5,
                'username' => 'eka',
                'password' => bcrypt('123456'),
                'nama_jabatan' => 5,
                'email' => Str::random(10).'@gmail.com',
                'role' => 'kepala_sub_bagian',
                'atasan_id' => '3',
                'name' => 'Eka'
            ],
            [
                'id' => 6,
                'username' => 'ferry',
                'password' => bcrypt('123456'),
                'nama_jabatan' => 6,
                'email' => Str::random(10).'@gmail.com',
                'role' => 'kepala_sub_bagian',
                'atasan_id' => '3',
                'name' => 'Ferry'
            ],
            [
                'id' => 7,
                'username' => 'gerry',
                'password' => bcrypt('123456'),
                'nama_jabatan' => 7,
                'email' => Str::random(10).'@gmail.com',
                'role' => 'staf',
                'atasan_id' => '5',
                'name' => 'Gerry'
            ],
            [
                'id' => 8,
                'username' => 'hari',
                'password' => bcrypt('123456'),
                'nama_jabatan' => 7,
                'email' => Str::random(10).'@gmail.com',
                'role' => 'staf',
                'atasan_id' => '5',
                'name' => 'Hari'
            ],
            [
                'id' => 9,
                'username' => 'admin',
                'password' => bcrypt('123456'),
                'nama_jabatan' => 8,
                'email' => Str::random(10).'@gmail.com',
                'role' => 'admin',
                'atasan_id' => null,
                'name' => 'Mimin'
            ]
        ];
        DB::table('users')->insert($dataUsers);
    }
}
