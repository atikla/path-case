<?php

namespace App\Schema\Api\Response\User;

use App\Schema\Api\Response\BaseAPIResponseSchema;

class UserFailureLoginSchema extends BaseAPIResponseSchema
{
    /**
     * @return string[]
     */
    public function getResponse(): array
    {
        return [];
    }
}
