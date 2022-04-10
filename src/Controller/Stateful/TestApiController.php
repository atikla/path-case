<?php

namespace App\Controller\Stateful;

use App\Interfaces\ConstantInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TestApiController extends AbstractController
{
    #[Route(
        path: '/test/',
        name: 'test',
        methods: [
            ConstantInterface::HTTP_POST_METHOD,
        ]
    )]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestApiController.php',
        ]);
    }
}
