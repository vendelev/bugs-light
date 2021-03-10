<?php

namespace App\Controller\Dto;

use Cake\Validation\Validator;

class TaskRequest implements ValidationInterface
{
    public $title;
    public $description;
    public $owner_id;
    public $worker_id;
    public $type_id;
    public $status_id;

    public function addValidation(Validator $validator): Validator
    {
        $validator->notBlank('title', 'Название обязательно для заполнения');
        $validator->notBlank('description', 'Описание обязательно для заполнения');

        $validator
            ->notBlank('owner_id', 'Автор обязателен для заполнения')
            ->integer('owner_id', 'ID должен быть числом')
            ->nonNegativeInteger('owner_id', 'ID должен быть положительным числом')
        ;

        $validator
            ->allowEmptyString('worker_id')
            ->integer('worker_id', 'ID должен быть числом')
            ->nonNegativeInteger('worker_id', 'ID должен быть положительным числом')
        ;

        $validator
            ->notBlank('type_id', 'Тип обязателен для заполнения')
            ->integer('type_id', 'Тип должен быть числом')
            ->nonNegativeInteger('type_id', 'Тип должен быть положительным числом')
        ;

        $validator
            ->notBlank('status_id', 'Статус обязателен для заполнения')
            ->integer('status_id', 'Статус должен быть числом')
            ->nonNegativeInteger('status_id', 'Статус должен быть положительным числом')
        ;

        return $validator;
    }
}
