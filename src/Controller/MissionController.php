<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/mission')]
final class MissionController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route(name: 'app_mission_index', methods: ['GET'])]
    public function index(MissionRepository $missionRepository): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour accéder à cette page.');
        return $this->render('mission/index.html.twig', [
            'missions' => $missionRepository->findAll(),
        ]);
    }

    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/new', name: 'app_mission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mission->setIsValidatedByAdmin(false);
            $mission->setNeedsRevalidation(false);

            $entityManager->persist($mission);
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission/new.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/{id}', name: 'app_mission_show', methods: ['GET'])]
    public function show(Mission $mission): Response
    {
        // $counterCandi = counter($mission->getApplications());

        return $this->render('mission/show.html.twig', [
            'mission' => $mission,
        ]);
    }

    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/{id}/edit', name: 'app_mission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission/edit.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/{id}', name: 'app_mission_delete', methods: ['POST'])]
    public function delete(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($mission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
    }

    #[isGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à cette page.')]
    #[Route('/applications/{id}', name: 'app_mission_applications', methods: ['GET'])]
    public function applications(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        $missionId = $request->attributes->get('id');
        $mission = $entityManager->getRepository(Mission::class)->find($missionId);
        $missionName = $mission ? $mission->getTitle() : 'Mission inconnue';

        $applications = $mission->getApplications();


        return $this->render('mission/show_application.html.twig', [
            'applications' => $applications,
            'missionName' => $missionName,
        ]);
    }
}
