<?php

namespace App\Controller;

use App\Entity\MissionStatus;
use App\Form\MissionStatusType;
use App\Service\MissionStatusService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
#[Route('/mission/status')]
final class MissionStatusController extends AbstractController
{
    public function __construct(private MissionStatusService $missionStatusService) {}

    #[Route(name: 'app_mission_status_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('mission_status/index.html.twig', [
            'mission_statuses' => $this->missionStatusService->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mission_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $missionStatus = new MissionStatus();
        $form = $this->createForm(MissionStatusType::class, $missionStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->missionStatusService->create($missionStatus);

            return $this->redirectToRoute('app_mission_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_status/new.html.twig', [
            'mission_status' => $missionStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_status_show', methods: ['GET'])]
    public function show(MissionStatus $missionStatus): Response
    {
        return $this->render('mission_status/show.html.twig', [
            'mission_status' => $missionStatus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mission_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MissionStatus $missionStatus): Response
    {
        $form = $this->createForm(MissionStatusType::class, $missionStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->missionStatusService->save($missionStatus);

            return $this->redirectToRoute('app_mission_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_status/edit.html.twig', [
            'mission_status' => $missionStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_status_delete', methods: ['POST'])]
    public function delete(Request $request, MissionStatus $missionStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionStatus->getId(), $request->getPayload()->getString('_token'))) {
            $this->missionStatusService->delete($missionStatus);
        }

        return $this->redirectToRoute('app_mission_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
