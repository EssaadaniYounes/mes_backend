<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=[
            ['name'=>'student'],
            ['name'=>'teacher'],
            ['name'=>'university'],
        ];

        foreach($roles as $role){
            Role::create($role);
        }

    }
}
