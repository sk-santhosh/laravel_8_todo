<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class admin_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return User::insert([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('admin@demo.com'),
            'role' => 'admin'
        ]);
    }
}
