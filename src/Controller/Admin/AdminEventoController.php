<?php

namespace App\Controller\Admin;

use App\Entity\Evento;
use App\Form\EventoType;
use App\Repository\EventoRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    ): Response {
        $eventos = $eventoRepository->findAll();

        return $this->render(
            'admin/evento/listar.html.twig',
            [
                'eventos' => $eventos,
            ]
        );
    }

    #[Route(
        '/inscriptos/{id}',
        name: 'admin_evento_inscriptos',
        requirements: ['id' => '\d+']
    )]
    public function inscriptos(
        int $id,
        EventoRepository $eventoRepository
    ): Response {
        $evento = $eventoRepository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'Evento no encontrado'
            );
        }

        return $this->render(
            'admin/evento/inscriptos.html.twig',
            [
                'evento' => $evento
            ]
        );
    }

    #[Route(
        '/{id}/inscriptos/{usuarioId}/borrar',
        name: 'admin_evento_inscripto_borrar',
        requirements: ['id' => '\d+', 'usuarioId' => '\d+'],
        methods: ['POST']
    )]
    public function borrarInscripto(
        int $id,
        int $usuarioId,
        Request $request,
        EventoRepository $eventoRepository,
        UsuarioRepository $usuarioRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $evento = $eventoRepository->find($id);
        $usuario = $usuarioRepository->find($usuarioId);

        if (!$evento || !$usuario) {
            throw $this->createNotFoundException(
                'Evento o usuario no encontrado.'
            );
        }

        $tokenId = 'borrar_inscripto_' . $evento->getId() . '_' . $usuario->getId();

        if (!$this->isCsrfTokenValid($tokenId, $request->request->get('_token'))) {
            $this->addFlash('danger', 'Token CSRF inválido.');

            return $this->redirectToRoute(
                'admin_evento_inscriptos',
                ['id' => $evento->getId()]
            );
        }

        $evento->removeUsuario($usuario);
        $entityManager->flush();

        $this->addFlash(
            'success',
            sprintf(
                'El usuario %s %s fue quitado del evento.',
                $usuario->getNombre(),
                $usuario->getApellido()
            )
        );

        return $this->redirectToRoute(
            'admin_evento_inscriptos',
            ['id' => $evento->getId()]
        );
    }

    #[Route(
        '/borrar/{id}',
        name: 'admin_evento_borrar',
        requirements: ['id' => '\d+']
    )]
    public function borrar(
        int $id,
        EventoRepository $eventoRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $evento = $eventoRepository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'No existe el evento solicitado.'
            );
        }

        $entityManager->remove($evento);
        $entityManager->flush();

        return $this->render(
            'admin/evento/borrar.html.twig',
            [
                'evento' => $evento
            ]
        );
    }

    #[Route(
        '/nuevo',
        name: 'admin_evento_nuevo',
        methods: ['GET', 'POST']
    )]
    public function nuevo(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $evento = new Evento();

        $form = $this->createForm(
            EventoType::class,
            $evento
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evento);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Evento creado correctamente.'
            );

            return $this->redirectToRoute('admin_evento_nuevo');
        }

        return $this->render(
            'admin/evento/nuevo.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}