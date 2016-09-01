<?php

class UpdateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Eloquent::unguard();

        // $this->call('UpdateUserSeeder');
        $user = User::where('username', 'YY')->update(array("permission" => "Admin"));
        $user = User::where('username', 'TT')->update(array("permission" => "TT"));
        $user = User::where('username', 'BB')->update(array("permission" => "BB"));
        
    }
}
