<?php
namespace App\Controller;

use App\Model\Table\TasksTable;
use App\Model\Table\UsersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use Cake\ORM\Query;

/**
 * @property TasksTable $Tasks
 * @property UsersTable $Users
 */
class TasksController extends AppController
{
    public function index(): void
    {
        $this->paginate = [
            'contain' => [
                'Owners' => function (Query $query) {
                    return $query->applyOptions(['withDeleted']);
                },
                'Workers' => function (Query $query) {
                    return $query->applyOptions(['withDeleted']);
                },
                'TaskTypes' => function (Query $query) {
                    return $query->applyOptions(['withDeleted']);
                },
                'TaskStatuses' => function (Query $query) {
                    return $query->applyOptions(['withDeleted']);
                }
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
                'Owners' => function (Query $query) {
                    return $query->applyOptions(['withDeleted']);
                },
                'Workers' => function (Query $query) {
                    return $query->applyOptions(['withDeleted']);
                },
                'TaskTypes' => function (Query $query) {
                    return $query->applyOptions(['withDeleted']);
                },
                'TaskStatuses' => function (Query $query) {
                    return $query->applyOptions(['withDeleted']);
                },
                'TaskComments' => [
                    'Users' => function (Query $query) {
                        return $query->applyOptions(['withDeleted']);
                    },
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
            $task = $this->Tasks->patchEntity($task, $this->getRequestAllData());
            if ($this->Tasks->save($task)) {
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

        $task = $this->Tasks->get($id, [
            'contain' => [],
        ]);

        $userId = $this->Auth->user('id');
        if ($task->owner_id !== $userId && $task->worker_id !== $userId) {
            $this->Flash->error(__('Вы можете только просматривать'));
            return $this->redirect(['action' => 'view', $task->id]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->getRequestAllData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }

        /** @var Query $users */
        $users = $this->loadModel('Users')->find('list', ['limit' => 200]);
        $users->union(
            $this->Users
                ->find('all', ['conditions' => ['id' => $task->owner_id], 'withDeleted'])
                ->select(['id', 'name'])
        );

        if ($task->worker_id) {
            $users->union(
                $this->Users
                    ->find('all', ['conditions' => ['id' => $task->worker_id], 'withDeleted'])
                    ->select(['id', 'name'])
            );
        }

        $taskTypes = $this->Tasks->TaskTypes->find('list', ['limit' => 200]);
        $taskStatuses = $this->Tasks->TaskStatuses->find('list', ['limit' => 200]);
        $this->set(compact('task', 'users', 'taskTypes', 'taskStatuses'));

        return null;
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

        if ($task->owner_id !== $this->Auth->user('id')) {
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
}
