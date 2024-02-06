<?php

namespace App\Interfaces;
use App\Services\PetRegistration\PetRegistrationObject;


interface PetRegistrationRepositoryInterface
{

    public function create(PetRegistrationObject $data);

    public function getAllByUser(int $userId);

    public function getById(int $id);

    public function update(int $id, array $data);

    public function delete(int $id);

}
