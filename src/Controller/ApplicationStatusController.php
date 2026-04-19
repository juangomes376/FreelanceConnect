<?php

namespace App\Controller;

use App\Entity\ApplicationStatus;
use App\Form\ApplicationStatusType;
use App\Service\ApplicationStatusService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN', message: 'Vous devez être connecté pour accéder à cette page.')]
#[Route('/application/status')]
final class ApplicationStatusController extends AbstractController
{
    public function __construct(private ApplicationStatusService $applicationStatusService) {}

    #[IsGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route(name: 'app_application_status_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('application_status/index.html.twig', [
            'application_statuses' => $this->applicationStatusService->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_application_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $applicationStatus = new ApplicationStatus();
        $form = $this->createForm(ApplicationStatusType::class, $applicationStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applicationStatusService->create($applicationStatus);

            return $this->redirectToRoute('app_application_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application_status/new.html.twig', [
            'application_status' => $applicationStatus,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/{id}', name: 'app_application_status_show', methods: ['GET'])]
    public function show(ApplicationStatus $applicationStatus): Response
    {
        return $this->render('application_status/show.html.twig', [
            'application_status' => $applicationStatus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_application_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApplicationStatus $applicationStatus): Response
    {
        $form = $this->createForm(ApplicationStatusType::class, $applicationStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applicationStatusService->save($applicationStatus);

            return $this->redirectToRoute('app_application_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application_status/edit.html.twig', [
            'application_status' => $applicationStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_application_status_delete', methods: ['POST'])]
    public function delete(Request $request, ApplicationStatus $applicationStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$applicationStatus->getId(), $request->getPayload()->getString('_token'))) {
            $this->applicationStatusService->delete($applicationStatus);
        }

        return $this->redirectToRoute('app_application_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
