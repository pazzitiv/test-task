<?php

namespace Modules\Auth\Http\Middleware;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\User\Entities\User;

class JWTGuard implements Guard
{
    use GuardHelpers;

    protected $hash;
    protected $request;
    protected $provider;

    private $token = null;

    public function __construct(
        UserProvider $provider,
        Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();

        if (!empty($token)) {
            $user = self::getCredentialsFromToken($token);
        }

        return $this->user = $user;
    }

    public function validate(array $credentials = [])
    {
        if ($this->user = $this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest(): ?string
    {
        $token = $this->request->bearerToken();

        return $token;
    }

    private function generateToken(User $user): string
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

        $payload = json_encode([
            'user_id' => $user->id,
            'si' => hash_hmac('sha3-512', $user->email, true),
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, env('JWT_KEY', ''), true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }

    private function getCredentialsFromToken(string $token)
    {
        $JWT = (object) array_combine(['header', 'payload', 'signature'], explode('.', $token));

        try {
            $header = json_decode(base64_decode($JWT->header));
            $payload = json_decode(base64_decode($JWT->payload));

            $user = User::find($payload->user_id);

            if($this->generateToken($user) !== $token) {
                return $this->user = null;
            }

        } catch (Exception $exception) {
            return $this->user = null;
        }

        return $this->user = $user;
    }

    public function login(array $credentials = [])
    {
        if($this->validate($credentials)) {
            $this->token = $this->generateToken($this->user());
        }

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
}
