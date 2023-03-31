<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'upm@upm.com',
            'password' => bcrypt(1234),
            'role_id' => 1
        ]);
        $user->createToken('LaravelAuthApp')->accessToken;
    }
}
