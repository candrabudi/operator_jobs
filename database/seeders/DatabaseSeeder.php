<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $storeAdmin = new User();
        $storeAdmin->full_name = "Super Admin";
        $storeAdmin->username = "superadmin";
        $storeAdmin->password = Hash::make('superadmin');
        $storeAdmin->phone_number = "085299818281";
        $storeAdmin->role = "superadmin";
        $storeAdmin->status = 1;
        $storeAdmin->save();
    }
}
