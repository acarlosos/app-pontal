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
        
        // DB::table('users')->insert([
        //     'name' => 'Antonio Carlos',
        //     'email' => 'acarlos.os@hotmail.com',
        //     'password' => bcrypt('pedro0409'),
        // ]);
        // DB::table('users')->insert([
        //     'name' => 'Andrea Nunes',
        //     'email' => 'andrea.nunes@pontaltelecom.com.br',
        //     'password' => bcrypt('nunes'),
        // ]);

         DB::table('users')->insert([
            'name' => 'juliana Flores',
            'email' => 'juliana.flores@pontaltelecom.com.br',
            'password' => bcrypt('flores'),
        ]);

        
    }
}
