<?php

namespace App\Controller\Api\Order;

use App\Exception\Json\JsonValidateException;
use App\Exception\Validation\ValidationException;
use App\Helper\Parser\JsonParser;
use App\Interfaces\ConstantInterface;
use App\Schema\Api\Response\Order\OrderStoreSchema;
use App\Service\Order\OrderStoreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/order/',
    name: 'order_store',
    methods: [ConstantInterface::HTTP_POST_METHOD]
)]
class OrderStoreController extends AbstractController
{
    /**
     * @param Request $request
     * @param OrderStoreService $orderStoreService
     * @return Response
     * @throws JsonValidateException
     * @throws ValidationException
     */
    public function __invoke(
        Request           $request,
        OrderStoreService $orderStoreService
    ): Response
    {
        $requestBody = JsonParser::parse($request->getContent());

        $order = $orderStoreService->validate($requestBody)->store();

        $orderSchema = (new OrderStoreSchema())
            ->setSuccessStatus()
            ->setStatusCode(Response::HTTP_OK)
            ->setMessage(ConstantInterface::ORDER_STORE_DONE_SUCCESSFULLY)
            ->setData($order->toArray());

        return new JsonResponse($orderSchema);
    }
}
