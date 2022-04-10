<?php

namespace App\Schema\Api\Response\Order;

use App\Schema\Api\Response\BaseAPIResponseSchema;

class OrderListSchema extends BaseAPIResponseSchema
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
     * @return OrderListSchema
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return ['orders' => $this->getData()];
    }
}
