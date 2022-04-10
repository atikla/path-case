<?php

namespace App\Schema\Api\Response\Product;

use App\Schema\Api\Response\BaseAPIResponseSchema;

class ProductListSchema extends BaseAPIResponseSchema
{
    private array $data;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return ProductListSchema
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getResponse(): array
    {
        return ['products' => $this->getData()];
    }
}
