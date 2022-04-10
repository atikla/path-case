<?php

namespace App\Schema\Api\Response\User;

use App\Schema\Api\Response\BaseAPIResponseSchema;

class UserRegisterSchema extends BaseAPIResponseSchema
{

    private string $token;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return UserRegisterSchema
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getResponse(): array
    {
        return [
            'token' => $this->getToken()
        ];
    }
}
