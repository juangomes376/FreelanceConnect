<?php

namespace App\Service;

use App\Entity\Address;
use App\Entity\User;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;


class AddressService
{
    public function __construct(
        private AddressRepository $addressRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function findAll(): array
    {
        return $this->addressRepository->findAll();
    }

    public function create(Address $address, User $user): void
    {
        $address->setUser($user);

        $this->entityManager->persist($address);
        $this->entityManager->flush();
    }

    public function save(Address $address): void
    {
        $this->entityManager->flush();
    }

    public function delete(Address $address): void
    {
        $this->entityManager->remove($address);
        $this->entityManager->flush();
    }
}
