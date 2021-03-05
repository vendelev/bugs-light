<?php

namespace App\Controller;

use App\Model\Table\TaskCommentsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;

/**
 * @property TaskCommentsTable $TaskComments
 */
class TaskCommentsController extends AppController
{
    /**
     * Add method
     *
     * @param int $id Task id.
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(int $id): ?Response
    {
        $comment = $this->TaskComments->newEntity();
        $comment->task_id = $id;
        $comment->user_id = $this->Auth->user('id');

        if ($this->request->is('post')) {
            $task = $this->TaskComments->patchEntity($comment, $this->getRequestAllData());
            if ($this->TaskComments->save($task)) {
                $this->Flash->success(__('Комментарий добавлен'));
            } else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
        }

        return $this->redirect(['controller' => 'Tasks', 'action' => 'view', $id]);
    }

    /**
     * Delete method
     *
     * @param int $id Task id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete(int $id): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->TaskComments->get($id);

        if ($comment->user_id !== $this->Auth->user('id')) {
            $this->Flash->error(__('Вы можете только просматривать'));
            return $this->redirect(['controller' => 'Tasks', 'action' => 'view', $comment->task_id]);
        }

        if ($this->TaskComments->delete($comment)) {
            $this->Flash->success(__('Комментарий удален'));
        } else {
            $this->Flash->error(__('The comment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Tasks', 'action' => 'view', $comment->task_id]);
    }
}
