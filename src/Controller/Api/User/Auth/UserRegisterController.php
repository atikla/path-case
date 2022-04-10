<?php

namespace App\Controller\Api\User\Auth;

use App\Exception\Json\JsonValidateException;
use App\Exception\Validation\ValidationException;
use App\Helper\Parser\JsonParser;
use App\Interfaces\ConstantInterface;
use App\Schema\Api\Response\User\UserRegisterSchema;
use App\Service\User\UserRegisterService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/user/register/',
    name: 'user_register',
    methods: [ConstantInterface::HTTP_POST_METHOD]
)]
class UserRegisterController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserRegisterService $userRegisterService
     * @param JWTTokenManagerInterface $jwtManager
     * @return Response
     * @throws JsonValidateException
     * @throws ValidationException
     */
    public function __invoke(
        Request $request,
        UserRegisterService $userRegisterService,
        JWTTokenManagerInterface $jwtManager
    ): Response
    {
        $requestBody = JsonParser::parse($request->getContent());

        $user = $userRegisterService->validate($requestBody)->register();

        $token = $jwtManager->create($user);

        $UserRegisterSchema = (new UserRegisterSchema())
            ->setSuccessStatus()
            ->setStatusCode(Response::HTTP_OK)
            ->setMessage(ConstantInterface::USER_REGISTER_DONE_SUCCESSFULLY)
            ->setToken($token);

        return new JsonResponse($UserRegisterSchema);
    }
}
