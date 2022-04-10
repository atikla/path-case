<?php

namespace App\Schema\Api\Response\User;

use App\Schema\Api\Response\BaseAPIResponseSchema;

class UserSuccessLoginSchema extends BaseAPIResponseSchema
{

    private array $data = [];

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return UserSuccessLoginSchema
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getResponse(): array
    {
        return $this->getData();
    }
}
