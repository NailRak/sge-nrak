<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EventoRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Evento;
use App\Service\EventoDisponibilidadService;

class EventoController extends AbstractController
{
    
    #[Route('/eventos', name: 'app_eventos')]
    public function eventos(EventoRepository $repository): Response
    {
    $eventos = $repository->findEventosAlfabeticamente();

    return $this->render('evento/eventos.html.twig', [
        'eventos' => $eventos
    ]);
    }

    #[Route('/evento/{slug}', name: 'app_evento_detalle')]
    public function evento(
    Request $request,
    EventoRepository $repository
): Response
{
    $slug = $request->attributes->get('slug');

    $evento = $repository->findOneBy(['slug' => $slug]);

    if (!$evento) {
        throw $this->createNotFoundException('No existe el evento solicitado');
    }

    return $this->render('evento/evento.html.twig', [
        'evento' => $evento
    ]);
    
   $this->addInfoMessage(
    sprintf(
        "Has leído sobre el evento '%s' a las %s.",
        $evento->getTitulo(),
        date('H:i:s')
    )
);

}
#[Route('/evento/{id}/disponibilidad', name: 'evento_disponibilidad')]
    public function disponibilidad(
        Evento $evento,
        EventoDisponibilidadService $disponibilidadService
    ): Response {
        $mensaje = $disponibilidadService->obtenerMensaje($evento);
        $tieneCupos = $disponibilidadService->tieneCupos($evento);

        return $this->render(
            'evento/disponibilidad.html.twig',
            [
                'evento' => $evento,
                'mensaje' => $mensaje,
                'tieneCupos' => $tieneCupos,
            ]
        );
    }

}