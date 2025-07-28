<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Load roles
        $userRole         = Role::where('name', 'user')->first();
        $superAdminRole   = Role::where('name', 'super_admin')->first();
        $adminRole        = Role::where('name', 'admin')->first();
        $technicianRole   = Role::where('name', 'technician')->first();
        $photographerRole = Role::where('name', 'photographer')->first();

        // Create test users for each role with @famousproduction.lb domain
        $testUsers = [
            [
                'role' => $superAdminRole,
                'email' => 'superadmin@famousproduction.lb',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'phone' => '+961 70 123 456',
                'address' => 'Famous Production HQ - Super Admin Office',
                'birthdate' => '1985-03-15',
            ],
            [
                'role' => $adminRole,
                'email' => 'admin@famousproduction.lb',
                'first_name' => 'Admin',
                'last_name' => 'Manager',
                'phone' => '+961 70 234 567',
                'address' => 'Famous Production HQ - Admin Office',
                'birthdate' => '1990-06-20',
            ],
            [
                'role' => $technicianRole,
                'email' => 'technician@famousproduction.lb',
                'first_name' => 'Tech',
                'last_name' => 'Support',
                'phone' => '+961 70 345 678',
                'address' => 'Famous Production HQ - IT Department',
                'birthdate' => '1992-09-10',
            ],
            [
                'role' => $photographerRole,
                'email' => 'photographer@famousproduction.lb',
                'first_name' => 'Photo',
                'last_name' => 'Artist',
                'phone' => '+961 70 456 789',
                'address' => 'Famous Production Studio',
                'birthdate' => '1988-12-05',
            ],
            [
                'role' => $userRole,
                'email' => 'user@famousproduction.lb',
                'first_name' => 'Regular',
                'last_name' => 'User',
                'phone' => '+961 70 567 890',
                'address' => 'Beirut, Lebanon',
                'birthdate' => '1995-04-25',
            ],
        ];

        foreach ($testUsers as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'password' => bcrypt('123123123'),
                    'birthdate' => $userData['birthdate'],
                    'phone' => $userData['phone'],
                    'address' => $userData['address'],
                    'latitude' => 33.8935, // Beirut coordinates
                    'longitude' => 35.5018,
                    'avatar' => null,
                    'email_verified_at' => now(),
                ]
            );

            // Ensure only one role per user
            $user->roles()->sync([$userData['role']->id]);
        }

        // Create additional regular users for testing (10 more users)
        for ($i = 1; $i <= 10; $i++) {
            $user = User::factory()->create([
                'email' => 'user' . $i . '@famousproduction.lb',
                'phone' => '+961 70 ' . (600 + $i) . ' ' . (100 + $i),
                'password' => bcrypt('123123123'),
                'email_verified_at' => now(),
            ]);
            $user->roles()->attach($userRole->id);
        }

        // Create additional photographers for testing (3 more photographers)
        for ($i = 2; $i <= 4; $i++) {
            $user = User::factory()->create([
                'first_name' => 'Photographer',
                'last_name' => 'Staff ' . $i,
                'email' => 'photographer' . $i . '@famousproduction.lb',
                'password' => bcrypt('123123123'),
                'phone' => '+961 70 ' . (500 + $i) . ' ' . (200 + $i),
                'address' => 'Famous Production Studio - Branch ' . $i,
                'email_verified_at' => now(),
            ]);
            $user->roles()->attach($photographerRole->id);
        }

        // Create additional technicians for testing (2 more technicians)
        for ($i = 2; $i <= 3; $i++) {
            $user = User::factory()->create([
                'first_name' => 'Technician',
                'last_name' => 'Staff ' . $i,
                'email' => 'technician' . $i . '@famousproduction.lb',
                'password' => bcrypt('123123123'),
                'phone' => '+961 70 ' . (400 + $i) . ' ' . (300 + $i),
                'address' => 'Famous Production HQ - IT Department',
                'email_verified_at' => now(),
            ]);
            $user->roles()->attach($technicianRole->id);
        }
    }
}
