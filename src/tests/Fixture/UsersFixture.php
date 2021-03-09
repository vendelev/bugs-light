<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public $import = ['model' => 'Users'];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'email' => 'example@test.ru',
                'pass' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-03-01 16:57:09',
                'modified' => '2021-03-01 16:57:09',
            ],
        ];
        parent::init();
    }
}
