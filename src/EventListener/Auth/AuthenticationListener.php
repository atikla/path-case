<?php

namespace App\EventListener\Auth;

use App\Interfaces\ConstantInterface;
use App\Schema\Api\Response\User\UserFailureLoginSchema;
use App\Schema\Api\Response\User\UserSuccessLoginSchema;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationListener
{
    /**
     * @param AuthenticationSuccessEvent $event
     * @return void
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $userSuccessLoginSchema = (new UserSuccessLoginSchema())
            ->setSuccessStatus()
            ->setStatusCode(Response::HTTP_OK)
            ->setMessage(ConstantInterface::USER_LOGIN_DONE_SUCCESSFULLY)
            ->setData($event->getData());

        $event->setData($userSuccessLoginSchema->toArray());
    }

    /**
     * @param AuthenticationFailureEvent $event
     * @return void
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $userFailureLoginSchema = (new UserFailureLoginSchema())
            ->setFailedStatus()
            ->setStatusCode(Response::HTTP_UNAUTHORIZED)
            ->setMessage($event->getException()->getMessage());

        $event->setResponse(new JsonResponse($userFailureLoginSchema));
    }
}
