<?php

namespace App\Controller\Api\Order;

use App\Exception\Json\JsonValidateException;
use App\Exception\Validation\ValidationException;
use App\Helper\Parser\JsonParser;
use App\Interfaces\ConstantInterface;
use App\Schema\Api\Response\Order\OrderStoreSchema;
use App\Service\Order\OrderUpdateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route(
    path: '/order/{orderCode}/',
    name: 'order_update',
    methods: [ConstantInterface::HTTP_PUT_METHOD]
)]
class OrderUpdateController extends AbstractController
{
    /**
     * @param Request $request
     * @param OrderUpdateService $orderUpdateService
     * @param TokenStorageInterface $tokenStorage
     * @param string $orderCode
     * @return Response
     * @throws JsonValidateException
     * @throws ValidationException
     */
    public function __invoke(
        Request $request,
        OrderUpdateService $orderUpdateService,
        TokenStorageInterface $tokenStorage,
        string $orderCode
    ): Response
    {
        $requestBody = JsonParser::parse($request->getContent());

        $order = $orderUpdateService->getOrderByCode(orderCode: $orderCode, user: $tokenStorage->getToken()->getUser());

        $orderUpdateService
            ->setOrder($order)
            ->validate($requestBody)
            ->update();

        $orderSchema = (new OrderStoreSchema())
            ->setSuccessStatus()
            ->setStatusCode(Response::HTTP_OK)
            ->setMessage(ConstantInterface::ORDER_UPDATE_DONE_SUCCESSFULLY)
            ->setData($order->toArray());

        return new JsonResponse($orderSchema);
    }
}
