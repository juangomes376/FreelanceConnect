<?php

namespace App\Service;

use App\Entity\Address;
use App\Repository\AddressRepository;


class AddressService
{
    private AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    // public function getAllAddresses()
    // {
    //     return $this->addressRepository->findAll();
    // }
}