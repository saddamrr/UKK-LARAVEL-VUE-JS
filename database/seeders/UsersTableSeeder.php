<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'nik' => '0987654321123456',
            'nama' => 'admin',
            'username' => 'admin@admin',
            'password' => bcrypt('qwerty'),
            'telp' => '08231355111',
            'level' => 'admin'
        ]);
    }
}
