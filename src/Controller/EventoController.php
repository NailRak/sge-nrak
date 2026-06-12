<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EventoRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Evento;

final class EventoController extends AbstractController
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

     $this->addFlash('info',
    sprintf(
        "Has leído sobre el evento '%s' a las %s.",
        $evento->getTitulo(),
        date('H:i:s')
    )
);


    if (!$evento) {
        throw $this->createNotFoundException('No existe el evento solicitado');
    }

    return $this->render('evento/evento.html.twig', [
        'evento' => $evento
    ]);
    


}
// #[Route('/evento/nuevo', name: 'evento_nuevo')]
// public function nuevo(
//     Request $request,
//     EntityManagerInterface $em
// ): Response {
//     $evento = new Evento();

//     $form = $this->createFormBuilder($evento)
//         ->add('titulo')
//         ->add('fecha')
//         ->getForm();

//     $form->handleRequest($request);

//     if ($form->isSubmitted() && $form->isValid()) {

//         $em->persist($evento);
//         $em->flush();

//         return $this->redirectToRoute('evento_lista');
//     }

//     return $this->render('evento/nuevo.html.twig', [
//         'form' => $form->createView()
//     ]);
// }
}