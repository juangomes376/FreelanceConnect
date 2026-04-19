<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Entity\User;
use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api')]
final class ApiController extends AbstractController
{
    // -------------------------------------------------------------------------
    // Endpoints publics
    // -------------------------------------------------------------------------

    #[Route('/missions/recent', name: 'api_missions_recent', methods: ['GET'])]
    public function recentMissions(MissionRepository $missionRepository): JsonResponse
    {
        $missions = $missionRepository->findRecentPublished(5);

        return $this->json(
            array_map(fn(Mission $m) => $this->serializeMission($m), $missions)
        );
    }

    #[Route('/missions', name: 'api_missions_index', methods: ['GET'])]
    public function allMissions(MissionRepository $missionRepository): JsonResponse
    {
        $missions = $missionRepository->findAllPublished();

        return $this->json(
            array_map(fn(Mission $m) => $this->serializeMission($m), $missions)
        );
    }

    // -------------------------------------------------------------------------
    // Endpoints privés (authentification requise)
    // -------------------------------------------------------------------------

    #[IsGranted('ROLE_USER', message: 'Accès refusé : authentification requise.')]
    #[Route('/missions/{id}/applications', name: 'api_mission_applications_count', methods: ['GET'])]
    public function missionApplicationsCount(
        int $id,
        MissionRepository $missionRepository
    ): JsonResponse {
        $mission = $missionRepository->find($id);

        if (!$mission) {
            return $this->json(['error' => 'Mission introuvable.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'mission_id'         => $mission->getId(),
            'mission_title'      => $mission->getTitle(),
            'applications_count' => $mission->getApplications()->count(),
        ]);
    }

    #[IsGranted('ROLE_USER', message: 'Accès refusé : authentification requise.')]
    #[Route('/client', name: 'api_clients_index', methods: ['GET'])]
    public function allClients(UserRepository $userRepository): JsonResponse
    {
        $clients = $userRepository->findByRole('ROLE_CLIENT');

        return $this->json(
            array_map(fn(User $u) => $this->serializeUser($u), $clients)
        );
    }

    #[IsGranted('ROLE_USER', message: 'Accès refusé : authentification requise.')]
    #[Route('/client/{id}', name: 'api_client_show', methods: ['GET'])]
    public function showClient(int $id, UserRepository $userRepository): JsonResponse
    {
        $client = $userRepository->find($id);

        if (!$client || !in_array('ROLE_CLIENT', $client->getRoles(), true)) {
            return $this->json(['error' => 'Client introuvable.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($this->serializeUser($client, true));
    }

    #[IsGranted('ROLE_USER', message: 'Accès refusé : authentification requise.')]
    #[Route('/freelance', name: 'api_freelances_index', methods: ['GET'])]
    public function allFreelances(UserRepository $userRepository): JsonResponse
    {
        $freelances = $userRepository->findByRole('ROLE_FREELANCER');

        return $this->json(
            array_map(fn(User $u) => $this->serializeUser($u), $freelances)
        );
    }

    #[IsGranted('ROLE_USER', message: 'Accès refusé : authentification requise.')]
    #[Route('/freelance/{id}', name: 'api_freelance_show', methods: ['GET'])]
    public function showFreelance(int $id, UserRepository $userRepository): JsonResponse
    {
        $freelance = $userRepository->find($id);

        if (!$freelance || !in_array('ROLE_FREELANCER', $freelance->getRoles(), true)) {
            return $this->json(['error' => 'Freelance introuvable.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($this->serializeUser($freelance, true));
    }

    // -------------------------------------------------------------------------
    // Helpers de sérialisation
    // -------------------------------------------------------------------------

    private function serializeMission(Mission $mission): array
    {
        return [
            'id'         => $mission->getId(),
            'title'      => $mission->getTitle(),
            'budget'     => $mission->getBudget(),
            'created_at' => $mission->getCreatedAt()?->format('Y-m-d H:i:s'),
            'category'   => $mission->getCategory()?->getName(),
            'language'   => $mission->getLanguage()?->getName(),
        ];
    }

    private function serializeUser(User $user, bool $withAddresses = false): array
    {
        $data = [
            'id'         => $user->getId(),
            'email'      => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name'  => $user->getLastName(),
            'siret'      => $user->getSiret(),
            'roles'      => $user->getRoles(),
            'created_at' => $user->getCreatedAt()?->format('Y-m-d H:i:s'),
            'is_verified' => $user->isVerified(),
        ];

        if ($withAddresses) {
            $data['addresses'] = array_map(
                fn($addr) => [
                    'alias'    => $addr->getAlias(),
                    'street'   => $addr->getStreet(),
                    'zip_code' => $addr->getZipCode(),
                    'city'     => $addr->getCity(),
                ],
                $user->getAddresses()->toArray()
            );
        }

        return $data;
    }
}

