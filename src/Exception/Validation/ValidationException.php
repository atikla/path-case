<?php

namespace App\Exception\Validation;

use App\Exception\BaseException;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends BaseException
{

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
       return [];
    }
}
