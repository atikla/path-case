<?php

namespace App\Exception;

use Exception;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

abstract class BaseException extends Exception implements HttpExceptionInterface
{
    /**
     * @var string|null
     */
    private ?string $exceptionCode;

    /**
     * AbstractException constructor.
     * @param string $message
     * @param string|null $exceptionCode
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', ?string $exceptionCode = null, $code = 0, Throwable $previous = null)
    {
        $this->exceptionCode = $exceptionCode;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string|null
     */
    public function getExceptionCode(): ?string
    {
        return $this->exceptionCode;
    }
}
