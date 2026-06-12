<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AbstractBaseControllerPhpController extends AbstractController
{
    #[Route('/abstract/base/controller/php', name: 'app_abstract_base_controller_php')]
    public function index(): Response
    {
        return $this->render('abstract_base_controller_php/index.html.twig', [
            'controller_name' => 'AbstractBaseControllerPhpController',
        ]);
    }
}
