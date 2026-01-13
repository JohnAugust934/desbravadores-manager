<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Verifica se já existe para não duplicar
        if (!User::where('email', 'admin@dbv.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@dbv.com',
                'password' => Hash::make('jkd123sn'),
                'is_super_admin' => true,
                'club_id' => null,
                'role' => 'admin'
            ]);
        }
    }
}
