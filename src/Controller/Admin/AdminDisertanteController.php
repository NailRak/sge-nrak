<?php

namespace App\Controller\Admin;

use App\Entity\Disertante;
use App\Form\DisertanteType;
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
    '/borrar/{id}',
    name: 'admin_disertante_borrar',
    requirements: ['id' => '\d+']
)]
public function borrar(
    int $id,
    DisertanteRepository $disertanteRepository,
    EntityManagerInterface $entityManager
): Response
{
    $disertante = $disertanteRepository->find($id);

    if (!$disertante) {
        throw $this->createNotFoundException(
            'No existe disertante solicitado.'
        );
    }

    $entityManager->remove($disertante);

    $entityManager->flush();

    return $this->render(
        'admin/evento/borrar.html.twig',
        [
            'evento' => $disertante
        ]
    );
}
    #[Route(
        '/nuevo',
        name: 'admin_disertante_nuevo',
        methods: ['GET', 'POST']
    )]
    public function nuevo(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $disertante = new Disertante();

        $form = $this->createForm(
            DisertanteType::class,
            $disertante
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($disertante);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Disertante creado correctamente.'
            );

            return $this->redirectToRoute('admin_disertante_nuevo');
        }

        return $this->render(
            'admin/disertantes/nuevo.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
    #[Route(
    '/editar/{id}',
    name: 'admin_disertante_editar',
    requirements: ['id' => '\d+'],
    methods: ['GET', 'POST']
)]
public function editar(
    int $id,
    Request $request,
    DisertanteRepository $disertanteRepository,
    EntityManagerInterface $entityManager
): Response {
    $disertante = $disertanteRepository->find($id);

    if (!$disertante) {
        throw $this->createNotFoundException(
            'No existe el disertante solicitado.'
        );
    }

    $form = $this->createForm(
        DisertanteType::class,
        $disertante
    );

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Disertante actualizado correctamente.'
        );

        return $this->redirectToRoute(
            'admin_disertante_listar'
        );
    }

    return $this->render(
        'admin/disertantes/editar.html.twig',
        [
            'form' => $form->createView(),
            'disertante' => $disertante,
        ]
    );
}

}
