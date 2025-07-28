<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'description' => 'Full access to all system features'],
            ['name' => 'admin', 'description' => 'Administrative access to manage users and settings'],
            ['name' => 'technician', 'description' => 'Responsible for technical operations and support'],
            ['name' => 'photographer', 'description' => 'Can upload and manage photos and galleries'],
            ['name' => 'user', 'description' => 'Standard user with limited permissions'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
