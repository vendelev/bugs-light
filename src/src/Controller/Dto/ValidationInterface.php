<?php

namespace App\Controller\Dto;

use Cake\Validation\Validator;

interface ValidationInterface
{
    public function addValidation(Validator $validator): Validator;
}
