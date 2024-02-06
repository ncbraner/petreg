<?php

namespace App\Http\Controllers;

use App\Exceptions\PetRegistrationExceptions;
use App\Http\Requests\PetRegistrationRequest;
use App\Http\Requests\UserAuthRequest;
use App\Models\PetRegistration;
use App\Repositories\PetRegistrationRepository;
use App\Services\PetRegistration\PetRegistrationService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class PetRegistrationController extends Controller
{
    private PetRegistrationService $petRegistrationService;
    protected $userService;

    public function __construct(PetRegistrationService    $petRegistrationService,
                                PetRegistrationRepository $petRegistrationRepository,
                                UserService               $userService)
    {
        $this->petRegistrationService = $petRegistrationService;
        $this->petRegistrationRepository = $petRegistrationRepository;
        $this->userService = $userService;
    }

    /**
     * Store a new pet registration.
     *
     * @param PetRegistrationRequest $request
     * @return JsonResponse
     */
    public function store(PetRegistrationRequest $request): JsonResponse
    {
        $authId = $request->input('authID');
        $userId = $this->userService->getUserId($authId);
        $request->merge(['userId' => $userId]);

        try {
            $petRegistrationData = $this->petRegistrationService->setData($request->all())->create();
            $this->petRegistrationRepository->create($petRegistrationData);
            return response()->json(['message' => 'Pet registration successful'], 201);
        } catch (PetRegistrationExceptions $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            // Log the error message for debugging
            Log::error($e->getMessage());
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }

    /**
     * Get all pet registrations by user.
     *
     * @param UserAuthRequest $request
     * @return JsonResponse
     */
    public function getAllByUser(UserAuthRequest $request): JsonResponse
    {
        $authId = $request->authId;
        $userId = $this->userService->getUserId($authId);
        $petRegistrations = $this->petRegistrationRepository->getAllByUser($userId);
        return response()->json($petRegistrations, 200);
    }
}
