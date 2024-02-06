<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use App\Exceptions\UserExceptions;

class UserService
{
    /**
     * @param string $userId
     * @return array|null
     * @throws UserExceptions
     */
    public function getUser(string $userId): ?array
    {
        try {
            $response = $this->makeRequest($userId);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw UserExceptions::userDataNotFound($e);
            return null;
        }
    }

    /**
     * @param string $userId
     * @return int|null
     * @throws UserExceptions
     */
    public function getUserId(string $userId): ?int
    {
        try {
            $response = $this->makeRequest($userId);
            return json_decode($response->getBody()->getContents(), true)['user']['id'];
        } catch (RequestException $e) {
            throw UserExceptions::userIdNotFound($e);
            return null;
        }
    }

    /**
     * @param string $userId
     * @return Response
     */
    private function makeRequest(string $userId): Response
    {
        return Http::get('http://usersvc-laravel.test-1/api/users/token/'. $userId);
    }
}
