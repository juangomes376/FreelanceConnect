<?php

namespace App\Controller;

use App\Entity\MissionStatus;
use App\Form\MissionStatusType;
use App\Repository\MissionStatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mission/status')]
final class MissionStatusController extends AbstractController
{
    #[Route(name: 'app_mission_status_index', methods: ['GET'])]
    public function index(MissionStatusRepository $missionStatusRepository): Response
    {
        return $this->render('mission_status/index.html.twig', [
            'mission_statuses' => $missionStatusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mission_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $missionStatus = new MissionStatus();
        $form = $this->createForm(MissionStatusType::class, $missionStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($missionStatus);
            $entityManager->flush();

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
    public function edit(Request $request, MissionStatus $missionStatus, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionStatusType::class, $missionStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_status/edit.html.twig', [
            'mission_status' => $missionStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_status_delete', methods: ['POST'])]
    public function delete(Request $request, MissionStatus $missionStatus, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionStatus->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mission_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
