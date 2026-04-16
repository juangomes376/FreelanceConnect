<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
#[Route('/application')]
final class ApplicationController extends AbstractController
{
    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route(name: 'app_application_index', methods: ['GET'])]
    public function index(ApplicationRepository $applicationRepository): Response
    {
        return $this->render('application/index.html.twig', [
            'applications' => $applicationRepository->findAll(),
        ]);
    }

    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/new', name: 'app_application_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($application);
            $entityManager->flush();

            return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application/new.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/{id}', name: 'app_application_show', methods: ['GET'])]
    public function show(Application $application): Response
    {
        return $this->render('application/show.html.twig', [
            'application' => $application,
        ]);
    }

    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/{id}/edit', name: 'app_application_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Application $application, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application/edit.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/{id}', name: 'app_application_delete', methods: ['POST'])]
    public function delete(Request $request, Application $application, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($application);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
    }
}
