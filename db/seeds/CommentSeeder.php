<?php

use Phinx\Seed\AbstractSeed;

class CommentSeeder extends AbstractSeed
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
                'comment' => $faker->text(2000),
                'status' => $faker->randomElement(['draft', 'published']),
                'user_id' => $faker->numberBetween(1, 10),
                'post_id' => $faker->numberBetween(1, 50),
                'created_at' => date('Y-m-d H:i:s', $faker->unixTime('now')),
                'updated_at' => date('Y-m-d H:i:s', $faker->unixTime('now'))
            ];
        }
        $this->table('comments')
            ->insert($data)
            ->save();
    }
}
