<?php

use Migrations\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    public function run(): void
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'email'   => $faker->email,
                'pass'    => password_hash('12345',  PASSWORD_DEFAULT),
                'name'    => $faker->name,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ];
        }

        $this->insert('users', $data);
    }
}
