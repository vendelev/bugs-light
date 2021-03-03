<?php
use Migrations\AbstractMigration;

class CreateTasks extends AbstractMigration
{
    public function change(): void
    {
        $date = date('Y-m-d H:i:s');

        $this->table('task_types', ['collation' => 'utf8_general_ci'])
            ->addColumn('title', 'string', [
                'limit' => 255,
                'null' => false,
            ])->addColumn('created', 'datetime', [
                'null' => false,
            ])->addColumn('modified', 'datetime', [
                'null' => false,
            ])->addColumn('deleted', 'datetime', [
                'null' => true,
                'default' => null
            ])
            ->addPrimaryKey('id')
            ->insert([
                ['title' => 'Срочный баг', 'created' => $date, 'modified' => $date],
                ['title' => 'Несрочный баг', 'created' => $date, 'modified' => $date],
                ['title' => 'Незначительное улучшение', 'created' => $date, 'modified' => $date],
            ])
            ->create()
        ;

        $this->table('task_statuses', ['collation' => 'utf8_general_ci'])
            ->addColumn('title', 'string', [
                'limit' => 255,
                'null' => false,
            ])->addColumn('created', 'datetime', [
                'null' => false,
            ])->addColumn('modified', 'datetime', [
                'null' => false,
            ])->addColumn('deleted', 'datetime', [
                'null' => true,
                'default' => null
            ])
            ->addPrimaryKey('id')
            ->insert([
                ['title' => 'Создана', 'created' => $date, 'modified' => $date],
                ['title' => 'В работе', 'created' => $date, 'modified' => $date],
                ['title' => 'Выполнена', 'created' => $date, 'modified' => $date],
                ['title' => 'Отменена', 'created' => $date, 'modified' => $date],
            ])
            ->create()
        ;

        $this->table('tasks', ['collation' => 'utf8_general_ci'])
            ->addColumn('title', 'text', [
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'null' => true,
            ])
            ->addColumn('owner_id', 'integer', [
                'null' => false,
                'comment' => 'Автор заявки',
            ])
            ->addColumn('worker_id', 'integer', [
                'null' => true,
                'comment' => 'Исполнитель заявки',
            ])
            ->addColumn('type_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('status_id', 'integer', [
                'null' => false,
            ])->addColumn('created', 'datetime', [
                'null' => false,
            ])->addColumn('modified', 'datetime', [
                'null' => false,
            ])->addColumn('deleted', 'datetime', [
                'null' => true,
                'default' => null
            ])
            ->addPrimaryKey('id')
            ->addForeignKeyWithName('task_owner', ['owner_id'], 'users')
            ->addForeignKeyWithName('task_worker', ['worker_id'], 'users')
            ->addForeignKeyWithName('task_type', ['type_id'], 'task_types')
            ->addForeignKeyWithName('task_status', ['status_id'], 'task_statuses')
            ->create()
        ;

        $this->table('task_comments', ['collation' => 'utf8_general_ci'])
            ->addColumn('user_id', 'integer', [
                'null' => false,
                'comment' => 'Автор комментария',
            ])
            ->addColumn('task_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('message', 'text', [
                'null' => false,
            ])->addColumn('created', 'datetime', [
                'null' => false,
            ])->addColumn('modified', 'datetime', [
                'null' => false,
            ])->addColumn('deleted', 'datetime', [
                'null' => true,
                'default' => null
            ])
            ->addPrimaryKey('id')
            ->addForeignKeyWithName('comment_user', ['user_id'], 'users')
            ->addForeignKeyWithName('comment_task', ['task_id'], 'tasks')
            ->create()
        ;
    }
}
