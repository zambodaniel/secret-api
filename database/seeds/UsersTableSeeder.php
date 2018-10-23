<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!\App\Models\User::where('email', '=', 'geza@jellyfactory.hu')->exists()) {
            \App\Models\User::create([
                'email' => 'geza@jellyfactory.hu',
                'name' => 'Teszt Geza',
                'password' => \Illuminate\Support\Facades\Hash::make('vryStrongPass')
            ]);
        }
    }
}
