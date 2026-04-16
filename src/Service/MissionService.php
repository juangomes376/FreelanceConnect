<?php

namespace App\Service;

use App\Entity\Mission;
use App\Repository\MissionRepository;


class MissionService
{
    private MissionRepository $missionRepository;

    public function __construct(MissionRepository $missionRepository)
    {
        $this->missionRepository = $missionRepository;
    }

    // public function getAllMissions()
    // {
    //     return $this->missionRepository->findAll();
    // }
}