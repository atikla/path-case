<?php

namespace App\Exception\Json;

use App\Exception\BaseException;
use Symfony\Component\HttpFoundation\Response;

class JsonValidateException extends BaseException
{

    /**
     * @inheritDoc
     */
    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;

    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return [];
    }
}
