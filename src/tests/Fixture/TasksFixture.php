<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class TasksFixture extends TestFixture
{
    public function init(): void
    {
//        $this->truncate();
        $this->records = [
            [
                'id' => 1,
                'title' => 'Test Task',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, 
                phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a 
                sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim 
                proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'owner_id' => 1,
                'worker_id' => 1,
                'type_id' => 1,
                'status_id' => 1,
                'created' => '2021-03-02 08:38:57',
                'modified' => '2021-03-02 08:38:57',
            ],
        ];
        parent::init();
    }
}
