<?php

namespace App\Controller\Api\Order;

use App\Interfaces\ConstantInterface;
use App\Schema\Api\Response\Order\OrderShowSchema;
use App\Service\Order\OrderShowService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


#[Route(
    path: '/order/{orderCode}/',
    name: 'order_show',
    methods: [ConstantInterface::HTTP_GET_METHOD]
)]
class OrderShowController extends AbstractController
{
    /**
     * @param Request $request
     * @param OrderShowService $orderShowService
     * @param TokenStorageInterface $tokenStorage
     * @param string $orderCode
     * @return Response
     */
    public function __invoke(
        Request $request,
        OrderShowService $orderShowService,
        TokenStorageInterface $tokenStorage,
        string $orderCode
    ): Response
    {
        $data = $orderShowService->getOrderByCode(orderCode: $orderCode, user: $tokenStorage->getToken()->getUser());

        $orderListSchema = (new OrderShowSchema())
            ->setStatusCode(Response::HTTP_OK)
            ->setSuccessStatus()
            ->setMessage(ConstantInterface::ORDER_SHOW_DONE_SUCCESSFULLY)
            ->setData($data);
        return new JsonResponse($orderListSchema);
    }
}
