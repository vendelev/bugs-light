<?php

use Migrations\AbstractSeed;

class O1UsersSeeder extends AbstractSeed
{
    public function run(): void
    {
        $faker = Faker\Factory::create('ru_RU');
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'email'   => $faker->email,
                'pass'    => password_hash('12345',  PASSWORD_DEFAULT),
                'name'    => $faker->name,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
                'deleted' => $faker->randomElement([date('Y-m-d H:i:s'), null]),
            ];
        }

        $this->insert('users', $data);
    }
}
