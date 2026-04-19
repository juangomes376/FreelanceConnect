<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Service\ApplicationService;
use App\Service\MissionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/mission')]
final class MissionController extends AbstractController
{
    public function __construct(private MissionService $missionService) {}

    #[Route(name: 'app_mission_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('mission/index.html.twig', [
            'missions' => $this->missionService->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mission_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->missionService->create($mission, $this->getUser());

            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission/new.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_show', methods: ['GET'])]
    public function show(Mission $mission, ApplicationService $applicationService): Response
    {
        $alreadyApplied = false;
        if ($this->isGranted('ROLE_FREELANCE') && $this->getUser()) {
            $alreadyApplied = $applicationService->hasAlreadyApplied($mission, $this->getUser());
        }

        return $this->render('mission/show.html.twig', [
            'mission' => $mission,
            'alreadyApplied' => $alreadyApplied,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mission $mission): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->missionService->save($mission);

            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission/edit.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_delete', methods: ['POST'])]
    public function delete(Request $request, Mission $mission): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->getPayload()->getString('_token'))) {
            $this->missionService->delete($mission);
        }

        return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/applications/{id}', name: 'app_mission_applications', methods: ['GET'])]
    public function applications(Mission $mission): Response
    {
        return $this->render('mission/show_application.html.twig', [
            'mission'      => $mission,
            'applications' => $mission->getApplications(),
        ]);
    }
}
