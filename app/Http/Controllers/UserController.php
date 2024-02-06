<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get the user.
     *
     * @param UserAuthRequest $request
     * @return JsonResponse
     */
    public function getUser(Request $request): JsonResponse
    {
        try {
            $userId = $request->authId;
            $user = $this->userService->getUser($userId);
            return response()->json($user, 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
