<?php

namespace App\Controller\Backoffice;

use App\Entity\Incident;
use App\Form\IncidentType;
use App\Repository\IncidentRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backoffice/incidents')]
class IncidentController extends AbstractController
{
    #[Route('/', name: 'app_backoffice_incident_index', methods: ['GET'])]
    public function index(IncidentRepository $incidentRepository): Response
    {
        return $this->render('backoffice/incident/index.html.twig', [
            'incidents' => $incidentRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_backoffice_incident_show', methods: ['GET'])]
    public function show(Incident $incident): Response
    {
        return $this->render('backoffice/incident/show.html.twig', [
            'incident' => $incident,
        ]);
    }

    #[Route('/{id}/process', name: 'app_backoffice_incident_process', methods: ['GET'])]
    public function markAsProcessed(Incident $incident, IncidentRepository $incidentRepository): Response
    {
        $incident->setProcessedAt(new DateTimeImmutable('now',new \DateTimeZone('Europe/Paris')));

        $incidentRepository->save($incident,true);

        return $this->render('backoffice/incident/show.html.twig', [
            'incident' => $incident,
        ]);
    }

    #[Route('/{id}/resolve', name: 'app_backoffice_incident_resolve', methods: ['GET'])]
    public function markAsResolved(Incident $incident, IncidentRepository $incidentRepository): Response
    {
        $incident->setResolveAt(new DateTimeImmutable('now',new \DateTimeZone('Europe/Paris')));

        $incidentRepository->save($incident,true);

        return $this->render('backoffice/incident/show.html.twig', [
            'incident' => $incident,
        ]);
    }


    #[Route('/{id}/reject', name: 'app_backoffice_incident_reject', methods: ['GET'])]
    public function markAsRejected(Incident $incident, IncidentRepository $incidentRepository): Response
    {
        $incident->setRejectedAt(new DateTimeImmutable('now',new \DateTimeZone('Europe/Paris')));

        $incidentRepository->save($incident,true);

        return $this->render('backoffice/incident/show.html.twig', [
            'incident' => $incident,
        ]);
    }

}
