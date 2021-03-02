<?php

use Migrations\AbstractSeed;

class O2TasksSeeder extends AbstractSeed
{
    public function run(): void
    {
        $faker = Faker\Factory::create();
        $tasks = [];
        $usersCnt = $this->fetchRow('select count(id) as cnt from users');
        $maxId = $usersCnt['cnt'];

        for ($ii = 0; $ii < 10; $ii++) {
            $tasks[] = [
                'title'   => $faker->text(),
                'desc'     => $faker->paragraph(),
                'owner_id' => random_int(1, $maxId),
                'worker_id'=> $faker->randomElement([random_int(1, $maxId), null]),
                'type_id'  => random_int(1, 3),
                'status_id'=> random_int(1, 4),
                'created'  => $faker->dateTimeBetween('-10 days', '-5 days')->format('Y-m-d H:i:s'),
                'modified' => $faker->dateTimeBetween('-4 days', 'now')->format('Y-m-d H:i:s'),
                'deleted' => $faker->randomElement([date('Y-m-d H:i:s'), null]),
            ];
        }

        $this->insert('tasks', $tasks);

        $comments = [];
        $tasks = $this->fetchAll('select * from tasks order by id desc limit 10');
        foreach ($tasks as $item) {
            $comments[] = [
                'task_id' => $item['id'],
                'user_id' => $item['owner_id'],
                'message' => $faker->paragraph(),
                'created' => $item['created'],
                'modified'=> $item['created'],
            ];

            if ($item['worker_id']) {
                $comments[] = [
                    'task_id' => $item['id'],
                    'user_id' => $item['worker_id'],
                    'message' => $faker->paragraph(),
                    'created' => $item['modified'],
                    'modified'=> $item['modified'],
                ];
            }
        }

        $this->insert('task_comments', $comments);
    }
}
