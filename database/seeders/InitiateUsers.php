<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitiateUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $users = [
        [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'is_admin' => true,
            'role' => 'admin',
            'password'=>Hash::make('12345678')
        ],
        [
            'name' => 'Coordinator',
            'email' => 'coordinator@admin.com',
            'is_admin' => false,
            'role' => 'coordinator',
            'password'=>Hash::make('12345678')
        ],
        [
            'name' => 'Developer 1',
            'email' => 'dev1@admin.com',
            'is_admin' => false,
            'role' => 'user',
            'password'=>Hash::make('12345678')
        ],
        [
            'name' => 'Developer 2',
            'email' => 'dev2@admin.com',
            'is_admin' => false,
            'role' => 'user',
            'password'=>Hash::make('12345678')
        ],
        [
            'name' => 'Specialist',
            'email' => 'spacialist@admin.com',
            'is_admin' => false,
            'role' => 'client',
            'password'=>Hash::make('12345678')
        ]
      ];
      foreach($users as $user) {
        \App\Models\User::create($user);
      }
    }
}
