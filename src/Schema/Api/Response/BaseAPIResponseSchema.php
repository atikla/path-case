<?php

namespace App\Schema\Api\Response;

use App\Interfaces\ArrayableInterface;
use App\Interfaces\ConstantInterface;
use JsonSerializable;

abstract class BaseAPIResponseSchema implements ArrayableInterface, JsonSerializable
{
    /**
     * @var string
     */
    protected string $status;

    /**
     * @var int
     */
    protected int $statusCode;

    /**
     * @var string
     */
    protected string $message;


    /**
     * @var string|null
     */
    protected ?string $exceptionCode = null;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return $this
     */
    public function setSuccessStatus(): self
    {
        $this->status = ConstantInterface::SUCCESS_STATUS;

        return $this;
    }

    /**
     * @return $this
     */
    public function setFailedStatus(): self
    {
        $this->status = ConstantInterface::FAILED_STATUS;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result[] = [
            'status' => $this->getStatus(),
            'statusCode' => $this->getStatusCode(),
            'message' => $this->getMessage(),
            'response' => $this->getResponse()
        ];

        if (($exceptionTypeCode = $this->getExceptionCode()) !== null) {
            $result[] = [
                'exceptionCode' => $exceptionTypeCode
            ];
        }

        return array_merge(...$result);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }


    /**
     * @return string|null
     */
    public function getExceptionCode(): ?string
    {
        return $this->exceptionCode;
    }

    /**
     * @param string|null $exceptionCode
     */
    public function setExceptionCode(?string $exceptionCode): void
    {
        $this->exceptionCode = $exceptionCode;
    }

    /**
     * @return array
     */
    abstract public function getResponse(): array;
}
