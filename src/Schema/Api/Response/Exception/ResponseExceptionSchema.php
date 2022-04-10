<?php

namespace App\Schema\Api\Response\Exception;

use App\Schema\Api\Response\BaseAPIResponseSchema;

class ResponseExceptionSchema extends BaseAPIResponseSchema
{
    /**
     * @return array
     */
    public function getResponse(): array
    {
        return [];
    }
}
