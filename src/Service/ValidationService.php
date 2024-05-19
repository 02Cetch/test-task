<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function validate($object): array
    {
        $errors = $this->validator->validate($object);

        if (count($errors) === 0) {
            return [];
        }

        return $this->formatErrors($errors);
    }

    private function formatErrors(ConstraintViolationListInterface $errors): array
    {
        $errorsArray = [];
        foreach ($errors as $error) {
            $errorsArray[$error->getPropertyPath()] = $error->getMessage();
        }
        return $errorsArray;
    }
}
