<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetType;
use App\Models\Breed;
use Illuminate\Http\JsonResponse;

class BreedController extends Controller
{
    /**
     * Get breeds by type.
     *
     * @param PetType $request
     * @return JsonResponse
     */
    public function getBreedsByType(PetType $request): JsonResponse
    {
        $type = $request->input('type');
        $breeds = Breed::getByType($type);

        if (!$breeds || $breeds->isEmpty()) {
            return response()->json(['error' => 'No breeds found for this type'], 404);
        }

        return response()->json($breeds);
    }
}
