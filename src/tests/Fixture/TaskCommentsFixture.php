<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TaskCommentsFixture
 */
class TaskCommentsFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'task_id' => 1,
                'message' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus 
                feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia 
                lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor 
                dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2021-03-02 08:39:54',
                'modified' => '2021-03-02 08:39:54',
            ],
        ];
        parent::init();
    }
}
