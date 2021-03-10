<?php
namespace App\Controller;

use App\Controller\Dto\DtoValidator;
use App\Controller\Dto\TaskRequest;
use App\Model\Entity\Task;
use App\Model\Table\TasksTable;
use App\Model\Table\UsersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use Cake\Http\ServerRequest;

/**
 * @property TasksTable $Tasks
 * @property UsersTable $Users
 */
class TasksController extends AppController
{
    protected DtoValidator $validator;

    public function __construct(
        ServerRequest $request = null,
        Response $response = null,
        $name = null,
        $eventManager = null,
        $components = null) {
        parent::__construct($request, $response, $name, $eventManager, $components);

        $this->validator = new DtoValidator(TaskRequest::class);
    }

    public function index(): void
    {
        $this->paginate = [
            'contain' => [
                'Owners' => $this->getWithDeletedClosure(),
                'Workers' => $this->getWithDeletedClosure(),
                'TaskTypes' => $this->getWithDeletedClosure(),
                'TaskStatuses' => $this->getWithDeletedClosure()
            ],
        ];

        $order = $this->getRequest()->getQueryParams()['order'] ?? [];
        $tasks = $this->paginate(
            $this->Tasks,
            [
                'order' => $order,
                'sortWhitelist' => ['type_id', 'status_id', 'created', 'modified']
            ]
        );

        $this->set('tasks', $tasks);
        $this->set('currentTableOrder', ['order' => $order]);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     *
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null): void
    {
        $task = $this->Tasks->get($id, [
            'contain' => [
                'Owners' => $this->getWithDeletedClosure(),
                'Workers' => $this->getWithDeletedClosure(),
                'TaskTypes' => $this->getWithDeletedClosure(),
                'TaskStatuses' => $this->getWithDeletedClosure(),
                'TaskComments' => [
                    'Users' => $this->getWithDeletedClosure(),
                ]
            ],
        ]);

        $this->set('task', $task);
        $this->set('newComment', $this->loadModel('TaskComments')->newEntity(['task_id' => $id]));
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        $task = $this->Tasks->newEntity();
        if ($this->request->is('post')) {
            if ($this->patchEntity($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }

        $users = $this->loadModel('Users')->find('list', ['limit' => 200]);
        $taskTypes = $this->Tasks->TaskTypes->find('list', ['limit' => 200]);
        $taskStatuses = $this->Tasks->TaskStatuses->find('list', ['limit' => 200]);
        $this->set(compact('task', 'users', 'taskTypes', 'taskStatuses'));

        return null;
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null): ?Response
    {
        $this->loadModel('Users');

        $task = $this->Tasks->get($id);

        if (!$this->checkAuthUser($task->owner_id) && !$this->checkAuthUser($task->worker_id)) {
            $this->Flash->error(__('Вы можете только просматривать'));
            return $this->redirect(['action' => 'view', $task->id]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->patchEntity($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }

        /** @var UsersTable $repo */
        $repo = $this->loadModel('Users');
        $users = $repo->findForEditTaskForm($task->owner_id, $task->worker_id);

        $taskTypes = $this->Tasks->TaskTypes->find('list', ['limit' => 200]);
        $taskStatuses = $this->Tasks->TaskStatuses->find('list', ['limit' => 200]);
        $this->set(compact('task', 'users', 'taskTypes', 'taskStatuses'));

        return null;
    }

    protected function patchEntity(Task $task): bool
    {
        $validator = $this->getValidator();
        $errors = $validator->validate($this->getRequestAllData());

        if (!$errors) {
            $task = $this->Tasks->patchEntity($task, $validator->getFilledData());
            if (!$task->getErrors() && $this->Tasks->save($task)) {
                return true;
            }
        }

        return false;
    }

    protected function getValidator(): DtoValidator
    {
        return $this->validator;
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);

        if (!$this->checkAuthUser($task->owner_id)) {
            $this->Flash->error(__('Вы можете только просматривать'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The task has been deleted.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function checkAuthUser(?int $userId): bool
    {
        return $userId === $this->Auth->user('id');
    }
}
