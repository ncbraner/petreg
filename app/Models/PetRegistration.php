<?php

namespace App\Models;

use App\Data\Validations\PetRegistrationValidations;
use App\Exceptions\PetRegistrationExceptions;
use App\Services\PetRegistration\PetRegistrationObject;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Throwable;

class PetRegistration extends Model
{
    use HasFactory;

    private PetRegistrationValidations $validator;

    protected $fillable = [
        'name',
        'type',
        'breed_id',
        'breed_detail',
        'gender',
        'mix_detail',
        'pet_registration_number',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->setPetRegistrationNumber();
        });
    }

    public function setPetRegistrationNumber(): void
    {
        $this->pet_registration_number = (string)Str::uuid();
    }

    /**
     * @param PetRegistrationObject|array $data
     * @return PetRegistration
     * @throws PetRegistrationExceptions|Throwable
     */
    public function createFormRequest(PetRegistrationObject|array $data): PetRegistration
    {
        $petRegistration = $this;
        $petRegistration->user_id = $data->user_id;
        $petRegistration->name = $data->name;
        $petRegistration->type = "$data->type";
        $petRegistration->breed_id = $data->breed ?? 1;
        $petRegistration->breed_detail = $data->breedDetail;
        $petRegistration->gender = $data->gender;
        $petRegistration->mix_detail = $data->mixDetail;

        try {
            $petRegistration->saveOrFail();
            return $petRegistration;
        } catch (Exception $e) {
            throw new PetRegistrationExceptions($message = 'Pet registration failed to save', $code = 422, $e);
        }
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getAllByUser(int $userId): Collection
    {
        return $this->where('user_id', $userId)->get();
    }
}
