<?php

use Illuminate\Database\Seeder;

class UserstableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\User::create([
    		'name'=>'Asfak',
    		'password'=>bcrypt('Asfak123'),
    		'email'=>'asfakmunna@yahoo.com',
    		'admin'=>1,
    		'avatar' => asset('avatars/avatar.jpg')
    	]);
    }
}
