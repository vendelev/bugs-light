<?php

namespace App\Controller\Dto;

use Cake\Validation\Validator;
use RuntimeException;

class DtoValidator
{
    public Validator $validator;
    public ValidationInterface $dtoClass;

    public function __construct(string $dtoClassName)
    {
        $this->validator = new Validator();
        $this->dtoClass = new $dtoClassName;

        if (!$this->dtoClass instanceof ValidationInterface) {
            throw new RuntimeException('Проверяемый объект должен реализовывать ValidationInterface');
        }

        $this->dtoClass->addValidation($this->validator);
    }

    public function validate(array $data): array
    {
        $filledData = $this->populate($data)->getFilledData();

        return $this->getValidator()->validate($filledData);
    }

    public function getFilledData(): array
    {
        return get_object_vars($this->getDtoClass());
    }

    protected function populate(array $data): self
    {
        $object = $this->getDtoClass();
        foreach ($data as $key => $value) {
            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        return $this;
    }

    protected function getValidator(): Validator
    {
        return $this->validator;
    }

    protected function getDtoClass(): ValidationInterface
    {
        return $this->dtoClass;
    }
}
