<?php
namespace App\Controller;

use App\Model\Entity\Task;
use App\Model\Table\TasksTable;
use App\Model\Table\UsersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

/**
 * @property TasksTable $Tasks
 * @property UsersTable $Users
 *
 * @method Task[]|ResultSetInterface paginate($object = null, array $settings = [])
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
        $tasks = $this->paginate($this->Tasks);

        $this->set(compact('tasks'));
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
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        $task = $this->Tasks->newEntity();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
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
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null): ?Response
    {
        $this->loadModel('Users');

        $task = $this->Tasks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }

        /** @var UsersTable|Query $users */
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
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The task has been deleted.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}