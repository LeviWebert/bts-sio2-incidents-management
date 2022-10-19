<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Form\IncidentType;
use App\Repository\IncidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_welcome')]
    public function welcome(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController::welcome',
        ]);
    }

    #[Route('/report-incident', name: 'app_report_incident', methods: ['GET', 'POST'])]
    public function new(Request $request, IncidentRepository $incidentRepository): Response
    {
        $incident = new Incident();
        $form = $this->createForm(IncidentType::class, $incident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $incidentRepository->save($incident, true);


            // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
            $this->addFlash(
                'success',
                "Your incident has been successfully created with reference ".$incident->getReference()
            );

            return $this->redirectToRoute('app_welcome', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('app/report.html.twig', [
            'incident' => $incident,
            'form' => $form,
        ]);
    }
}
