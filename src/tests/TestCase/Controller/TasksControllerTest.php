<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TasksController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses TasksController
 */
class TasksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Tasks',
        'app.Users',
        'app.TaskTypes',
        'app.TaskStatuses',
        'app.TaskComments',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->session([
                           'Auth' => [
                               'User' => [
                                   'id' => 1,
                                   'username' => 'testing',
                               ]
                           ]
                       ]);
    }

    /**
     * @test
     */
    public function index()
    {
        $this->get('/tasks');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Task');
    }

    /**
     * @test
     */
    public function view()
    {
        $this->get('/tasks/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Task');
    }

    /**
     * @test
     */
    public function add()
    {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->post('/tasks/add', [
            'title' => 'Test-task2',
            'description' => 'test',
            'owner_id' => 1,
            'type_id' => 1,
            'status_id' => 1,
        ]);
        $this->assertRedirect(['controller' => 'Tasks', 'action' => 'index']);

        $users = TableRegistry::getTableLocator()->get('Tasks');
        $query = $users->find()->where(['title' => 'Test-task2']);
        self::assertEquals(1, $query->count());
    }

    /**
     * @test
     */
    public function edit()
    {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->post('/tasks/edit/1', [
            'title' => 'Test-task2',
            'description' => 'test',
            'owner_id' => 1,
            'type_id' => 1,
            'status_id' => 1,
        ]);
        $this->assertRedirect(['controller' => 'Tasks', 'action' => 'index']);

        $users = TableRegistry::getTableLocator()->get('Tasks');
        $query = $users->find()->where(['title' => 'Test-task2']);
        self::assertEquals(1, $query->count());
    }

    public function testDelete()
    {
        $this->enableCsrfToken();
        $this->delete('/tasks/delete/1');
        $this->assertRedirect(['controller' => 'Tasks', 'action' => 'index']);

        $users = TableRegistry::getTableLocator()->get('Tasks');
        $query = $users->find()->where(['id' => 1]);
        self::assertEquals(0, $query->count());
    }
}
