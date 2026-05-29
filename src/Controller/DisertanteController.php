<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DisertanteController extends AbstractController
{
   #[Route('/disertantes', name: 'app_disertantes')]
public function disertantes(): Response
{
}

}
