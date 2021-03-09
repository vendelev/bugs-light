<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class TaskStatusesFixture extends TestFixture
{
    public $import = ['model' => 'TaskStatuses'];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-03-02 08:38:50',
                'modified' => '2021-03-02 08:38:50',
            ],
        ];
        parent::init();
    }
}
