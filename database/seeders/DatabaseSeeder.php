<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ConfigSeeder::class,
            PayMethodSeeder::class,
            ReportTypesSeeder::class,
            CitySeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            ProductSeeder::class,
            ClientSeeder::class,
            VendorSeeder::class
        ]);
    }
}
