<?php

namespace App\EventListener;

use App\Exception\BaseException;
use App\Schema\Api\Response\Exception\ResponseExceptionSchema;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $exceptionSchema = (new ResponseExceptionSchema())
            ->setFailedStatus()
            ->setStatusCode($exception->getCode())
            ->setMessage($exception->getMessage());


        if ($exception instanceof BaseException) {
            $exceptionSchema
                ->setExceptionCode($exception->getExceptionCode());
        }

        $response = new Response();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $exceptionSchema->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $exceptionSchema->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response->setContent(json_encode($exceptionSchema));

        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse($response);
    }
}
