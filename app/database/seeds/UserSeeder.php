<?php

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Eloquent::unguard();

        // $this->call('UserTableSeeder');
        User::create(array('username' => 'YY', 'password' => Hash::make('YY'), 'permission' => 'Admin'));
        User::create(array('username' => 'TT', 'password' => Hash::make('TT'), 'permission' => 'TT'));
        User::create(array('username' => 'BB', 'password' => Hash::make('BB'), 'permission' => 'BB'));
    }
}
