<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public $fixtures = [
        'app.Users',
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
    public function index(): void
    {
        $this->session([]);
        $this->get('/users');
        $this->assertResponseOk();
    }

    /**
     * @test
     */
    public function view(): void
    {
        $this->get('/users/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('example@test.ru');
    }

    /**
     * @test
     */
    public function add(): void
    {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->post('/users/add', [
            'email' => 'test@test.ru',
            'pass' => '12345'
        ]);
        $this->assertResponseOk();
        $this->assertFlashMessage('The user could not be saved. Please, try again.', 'flash');

        $this->post('/users/add', [
            'email' => 'test@test.ru',
            'pass' => '12345',
            'name' => 'test'
        ]);
        $this->assertRedirect(['controller' => 'Users', 'action' => 'index']);

        $users = TableRegistry::getTableLocator()->get('Users');
        $query = $users->find()->where(['email' => 'test@test.ru']);
        self::assertEquals(1, $query->count());
    }

    /**
     * @test
     */
    public function edit(): void
    {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->post('/users/edit/1', [
            'email' => 'test',
            'pass' => '12345',
            'name' => 'test'
        ]);
        $this->assertResponseOk();
        $this->assertResponseContains('The user could not be saved');

        $this->post('/users/edit/1', [
            'email' => 'test@test.ru',
            'pass' => '12345',
            'name' => 'test'
        ]);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'index']);

        $users = TableRegistry::getTableLocator()->get('Users');
        $query = $users->find()->where(['email' => 'test@test.ru']);
        self::assertEquals(1, $query->count());
    }

    public function testDelete(): void
    {
        $this->enableCsrfToken();
        $this->delete('/users/delete/1');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'index']);

        $users = TableRegistry::getTableLocator()->get('Users');
        $query = $users->find()->where(['id' => 1]);
        self::assertEquals(0, $query->count());
    }
}
