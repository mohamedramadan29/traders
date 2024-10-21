<?php

namespace Database\Seeders;

use App\Models\admin\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        $admin->create([
            'name'=>'Mohamed',
            'type'=>'admin',
            'email'=>'mr319242@gmail.com',
            'phone'=>'0000000',
            'password'=>Hash::make('11111111'),
            'confirm'=>1,
        ]);
    }
}
