<?php

namespace App\Repositories;

use App\Data\Validations\PetRegistrationValidations;
use App\Events\PetRegistrationEvent;
use App\Exceptions\PetRegistrationExceptions;
use App\Interfaces\PetRegistrationRepositoryInterface;
use App\Models\PetRegistration;
use App\Services\PetRegistration\PetRegistrationObject;
use Illuminate\Support\Facades\Cache;
use SebastianBergmann\Type\VoidType;
use Throwable;

class PetRegistrationRepository implements PetRegistrationRepositoryInterface
{
    /**
     * @var PetRegistration
     */
    protected $model;

    /**
     * @var PetRegistrationValidations
     */
    protected $validator;

    /**
     * PetRegistrationRepository constructor.
     *
     * @param PetRegistration $petRegistration
     * @param PetRegistrationValidations $validator
     */
    public function __construct(PetRegistration $petRegistration, PetRegistrationValidations $validator)
    {
        $this->model = $petRegistration;
        $this->validator = $validator;
    }

    /**
     * @param PetRegistrationObject $data
     * @return PetRegistration
     * @throws Throwable
     * @throws PetRegistrationExceptions
     */
    public function create(PetRegistrationObject $data): PetRegistration
    {
        try {
            $this->validator->setData((array)$data);
            $this->validator->validate();

            $petRegistration = $this->model->createFormRequest($data);

            // Dispatch the PetRegistrationEvent
            event(new PetRegistrationEvent($petRegistration));

            return $petRegistration;
        } catch (Throwable $e) {
            // Handle the exception
            throw new PetRegistrationExceptions($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param int $userId
     * @return mixed
     * @throws Throwable
     * @throws PetRegistrationExceptions
     */
    public function getAllByUser(int $userId): mixed
    {
        try {
            $key = "petRegistrations.{$userId}";
            // Check if the data is in the cache
            if (Cache::has($key)) {
                return Cache::get($key);
            }

            // If not, retrieve the data from the database and store it in the cache
            $petRegistrations = $this->model->getAllByUser($userId);
            Cache::put($key, $petRegistrations, 60); // Cache the data for 60 minutes

            return $petRegistrations;
        } catch (Throwable $e) {
            // Handle the exception
            throw new PetRegistrationExceptions($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function getById(int $id)
    {
        // TODO: Implement getById() method.
    }

    /**
     * @param int $id
     * @param array $data
     * @return void
     */
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }
}
