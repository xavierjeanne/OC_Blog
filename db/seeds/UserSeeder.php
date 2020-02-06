<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [];
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'name' => $faker->LastName,
                'first_name' => $faker->firstName,
                'login' => $faker->userName,
                'password' => $faker->password,
                'status' => $faker->randomElement(['visitor', 'admin']),
                'email' => $faker->email,
            ];
        }
        $this->table('users')
            ->insert($data)
            ->save();
    }
}
