<?php

use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
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
        for ($i = 0; $i < 50; $i++) {
            $data[] = [
                'title' => $faker->catchPhrase,
                'abstract' => $faker->catchPhrase,
                'content' => $faker->text(2000),
                'status' => $faker->randomElement(['draft', 'published']),
                'user_id' => $faker->randomElement([1, 4, 6, 7, 9, 10]),
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime('now')),
                'updated_at' => date('Y-m-d H:i:s', $faker->unixTime('now'))
            ];
        }
        $this->table('posts')
            ->insert($data)
            ->save();
    }
}
