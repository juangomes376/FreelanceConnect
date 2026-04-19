<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\MissionRepository;
use App\Service\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
#[Route('/application')]
final class ApplicationController extends AbstractController
{
    public function __construct(private ApplicationService $applicationService) {}

    #[Route(name: 'app_application_index', methods: ['GET'])]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_FREELANCE')) {
            $applications = $this->applicationService->findByFreelancer($this->getUser());
        } else {
            $applications = $this->applicationService->findAll();
        }

        return $this->render('application/index.html.twig', [
            'applications' => $applications,
        ]);
    }

    #[Route('/new', name: 'app_application_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applicationService->create($application);

            return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application/new.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[Route('/new/{id}', name: 'app_application_new_mission', methods: ['GET', 'POST'])]
    public function newForMission(int $id, Request $request, MissionRepository $missionRepository): Response
    {
        $mission = $missionRepository->find($id);

        if (!$mission) {
            throw $this->createNotFoundException('Mission introuvable.');
        }

        if ($this->applicationService->hasAlreadyApplied($mission, $this->getUser())) {
            $this->addFlash('warning', 'Vous avez déjà postulé à cette mission.');
            return $this->redirectToRoute('app_mission_show', ['id' => $id]);
        }

        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cvFile = $form->get('cvFilename')->getData();
            $this->applicationService->createForMission($application, $mission, $this->getUser(), $cvFile);

            return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application/new.html.twig', [
            'missionName' => $mission->getTitle(),
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_application_show', methods: ['GET'])]
    public function show(Application $application): Response
    {
        return $this->render('application/show.html.twig', [
            'application' => $application,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_application_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Application $application): Response
    {
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applicationService->save($application);

            return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application/edit.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_application_delete', methods: ['POST'])]
    public function delete(Request $request, Application $application): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->getPayload()->getString('_token'))) {
            $this->applicationService->delete($application);
        }

        return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/accept', name: 'app_application_accept', methods: ['POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function accept(Request $request, Application $application): Response
    {
        if ($this->isCsrfTokenValid('status'.$application->getId(), $request->getPayload()->getString('_token'))) {
            $this->applicationService->accept($application);
        }

        return $this->redirectToRoute('app_mission_applications', ['id' => $application->getMission()->getId()]);
    }

    #[Route('/{id}/refuse', name: 'app_application_refuse', methods: ['POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function refuse(Request $request, Application $application): Response
    {
        if ($this->isCsrfTokenValid('status'.$application->getId(), $request->getPayload()->getString('_token'))) {
            $this->applicationService->refuse($application);
        }

        return $this->redirectToRoute('app_mission_applications', ['id' => $application->getMission()->getId()]);
    }
}
