<?php

namespace App\Controller\Admin;

use App\Repository\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/evento')]
class AdminEventoController extends AbstractController
{
    #[Route(
        '/listar',
        name: 'admin_evento_listar'
    )]
    public function listar(
        EventoRepository $eventoRepository
    ): Response
    {
        $eventos = $eventoRepository->findAll();

        return $this->render(
            'admin/evento/listar.html.twig',
            [
                'eventos' => $eventos
            ]
        );
    }
}