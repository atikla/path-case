<?php

namespace App\Controller\Api\Order;

use App\Interfaces\ConstantInterface;
use App\Schema\Api\Response\Order\OrderListSchema;
use App\Service\Order\OrderListService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


#[Route(
    path: '/order/',
    name: 'order_list',
    methods: [ConstantInterface::HTTP_GET_METHOD]
)]
class OrderListController extends AbstractController
{
    /**
     * @param Request $request
     * @param OrderListService $orderListService
     * @param TokenStorageInterface $tokenStorage
     * @return Response
     */
    public function __invoke(
        Request $request,
        OrderListService $orderListService,
        TokenStorageInterface $tokenStorage
    ): Response
    {
        $page = (int) $request->get('page', 1);
        $page = $page === 0 ? 1 : $page;

        $data = $orderListService->getOrderList(page: $page, user: $tokenStorage->getToken()->getUser());

        $orderListSchema = (new OrderListSchema())
            ->setStatusCode(Response::HTTP_OK)
            ->setSuccessStatus()
            ->setMessage(sprintf(ConstantInterface::ORDER_LIST_DONE_SUCCESSFULLY, $page))
            ->setData($data);
        return new JsonResponse($orderListSchema);
    }
}
