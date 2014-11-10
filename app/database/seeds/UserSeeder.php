<?php
class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();
        User::create(array(
            'email'    => 'alexeev.sker@gmail.com',
            'full_name'=> 'Anton Alexeev',
            'password' => Hash::make('123123'),
            'role'=>'admin'
        ));

        $faker = Faker\Factory::create('en_GB');

        $count = 4;

        $this->command->info('Inserting '.$count.' sample records using Faker ...');

        for( $x=0 ; $x<$count; $x++ )
        {
            User::create(array(
                'email' => $faker->email(),
                'full_name' => $faker->name,
                'password'=>Hash::make('123QWE'),
                'role'=>"user"
            ));
        }
    }
}