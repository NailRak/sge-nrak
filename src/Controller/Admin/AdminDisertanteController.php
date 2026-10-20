<?php

namespace App\Controller\Admin;

use App\Entity\Disertante;
use App\Repository\DisertanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/disertantes')]
class AdminDisertanteController extends AbstractController
{
    #[Route(
        '/listar',
        name: 'admin_disertante_listar'
    )]
    public function listar(
       DisertanteRepository $disertanteRepository
    ): Response {
        $disertantes = $disertanteRepository->findAll();

        return $this->render(
            'admin/disertantes/listar.html.twig',
            [
                'disertantes' => $disertantes,
            ]
        );
    }

    #[Route(
    '/inscriptos/{id}',
    name: 'admin_disertante_inscriptos',
    requirements: ['id' => '\d+']
)]
public function inscriptos(
    int $id,
    DisertanteRepository $disertanteRepository
): Response
{
    $evento = $disertanteRepository->find($id);

    if (!$evento) {
        throw $this->createNotFoundException(
            'disertante no encontrado'
        );
    }

    return $this->render(
        'admin/disertantes/inscriptos.html.twig',
        [
            'evento' => $evento
        ]
    );
}

}
