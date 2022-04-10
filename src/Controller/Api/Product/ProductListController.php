<?php

namespace App\Controller\Api\Product;

use App\Interfaces\ConstantInterface;
use App\Schema\Api\Response\Product\ProductListSchema;
use App\Service\Product\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route(
    path: '/product/',
    name: 'product_list',
    methods: [ConstantInterface::HTTP_GET_METHOD]
)]
class ProductListController extends AbstractController
{

    /**
     * @param Request $request
     * @param ProductService $productService
     * @return Response
     */
    public function __invoke(
        Request $request,
        ProductService $productService,
    ): Response
    {
        $page = (int) $request->get('page', 1);

        $page = $page === 0 ? 1 : $page;

        $data = $productService->getProductList($page);

        $productListSchema = (new ProductListSchema())
            ->setStatusCode(Response::HTTP_OK)
            ->setSuccessStatus()
            ->setMessage(sprintf(ConstantInterface::PRODUCT_LIST_DONE_SUCCESSFULLY, $page))
            ->setData($data);

        return new JsonResponse($productListSchema);
    }
}
