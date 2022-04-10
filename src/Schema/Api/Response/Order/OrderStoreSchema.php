<?php

namespace App\Schema\Api\Response\Order;

use App\Schema\Api\Response\BaseAPIResponseSchema;

class OrderStoreSchema extends BaseAPIResponseSchema
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
     * @return OrderStoreSchema
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
        return ['order' => $this->getData()];
    }
}
