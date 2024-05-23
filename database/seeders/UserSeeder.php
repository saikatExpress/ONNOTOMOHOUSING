<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now      = Carbon::now();
        $password = '123456';

        User::insert([
            [
                'id'         => 1,
                'name'       => 'Saikat Talukder',
                'email'      => 'saikathosen444@gmail.com',
                'mobile'     => '01713617913',
                'whatsapp'   => '01713617913',
                'address'    => 'Netrakona , Mymensingh',
                'password'   => Hash::make($password),
                'role'       => 'user',
                'created_at' => $now,
            ],
            [
                'id'         => 2,
                'name'       => 'ONNOTOMO ADMIN',
                'email'      => 'admin@gmail.com',
                'mobile'     => '01714761685',
                'whatsapp'   => '01714761685',
                'address'    => 'Nikunjo,Khilkhet,Dhaka',
                'password'   => Hash::make($password),
                'role'       => 'admin',
                'created_at' => $now,
            ],
        ]);
    }
}
