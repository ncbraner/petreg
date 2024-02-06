<?php

namespace App\Http\Middleware;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Auth0\SDK\Exception\ConfigurationException;
use Closure;
use Exception;


class CheckAuth0Token
{
    public function handle($request, Closure $next)
    {
        if (!$this->validateToken($request->bearerToken())) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    /**
     * @throws ConfigurationException
     */
    private function validateToken($token)
    {
        if ($token === null) {
            return false;
        }

        $config = new SdkConfiguration(
            strategy: SdkConfiguration::STRATEGY_API,
            domain: env('VITE_AUTH0_DOMAIN'),
            audience: [env('VITE_AUTH0_CLIENT_ID'), env('VITE_AUTH0_AUDIENCE')]
        );

        $auth0 = new Auth0($config);

        try {
            $auth0->decode($token);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
