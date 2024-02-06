<?php

namespace App\Services\PetRegistration;

use App\Data\Validations\PetRegistrationValidations;
use App\Exceptions\PetRegistrationExceptions;
use App\Repositories\PetRegistrationRepository;
use Throwable;

class PetRegistrationService
{
    protected $data;
    private PetRegistrationValidations $validator;
    private PetRegistrationObject $petRegistration;

    public function __construct(PetRegistrationObject $petRegistration, PetRegistrationValidations $validator, PetRegistrationRepository $petRepository)
    {
        $this->petRegistration = $petRegistration;
        $this->validator = $validator;
        $this->petRepository = $petRepository;
    }

    /**
     * @param array $data
     * @return self
     * @throws PetRegistrationExceptions
     */
    public function setData(array $data): self
    {
        $this->validator->setData($data);
        $this->validator->validate();
        $this->data = $data;
        return $this;
    }

    /**
     * @return PetRegistrationObject
     */
    public function create(): PetRegistrationObject
    {
        $this->petRegistration->user_id = $this->data['userId']; // This should be replaced with the actual user ID
        $this->petRegistration->name = $this->data['name'];
        $this->petRegistration->type = $this->data['type'];
        $this->petRegistration->breed = $this->data['breed'] ?? 1;
        $this->petRegistration->breedDetail = $this->data['breedDetail'];
        $this->petRegistration->gender = $this->data['gender'];
        $this->petRegistration->mixDetail = $this->data['mixDetail'];

        return $this->petRegistration;
    }

    /**
     * @throws Throwable
     * @throws PetRegistrationExceptions
     */
    public function storePet(): void
    {
        $this->petRepository->create($this->petRegistration);
    }
}
