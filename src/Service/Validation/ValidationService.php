<?php

namespace App\Service\Validation;

use App\Exception\Validation\ValidationException;
use App\Interfaces\ValidatableInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param ValidatableInterface $schema
     * @throws ValidationException
     */
    public function validate(ValidatableInterface $schema): void
    {
        $errors = [];

        $schemaErrors = $this->validator->validate($schema);

        if ($schemaErrors->count() > 0) {
            foreach ($schemaErrors as $schemaError) {
                $errors[$schemaError->getPropertyPath()][] = $schemaError->getPropertyPath() . ": " . $schemaError->getMessage();
                break;
            }

            throw new ValidationException(
                implode(', ', array_merge(...array_values($errors)))
            );
        }
    }
}
