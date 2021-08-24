<?php

declare(strict_types=1);

Namespace app\Users\Infrastructure\Authentication\Tokenization;

use Exception;
use \Firebase\JWT\JWT;
 
/**
 * Management JWT tokens
 */
class JWTTokenization implements TokenizationInterface
{
    private int $expiration_in_seconds;
    private string $domain;
    private string $key;

    public function __construct() {
        $this->expiration_in_seconds = (int) env('JWT_EXPIRATION_IN_SECS', 432000);
        $this->domain = env('JWT_DOMAIN', 'crudshell.com');
        $this->key = env('JWT_KEY', '7Fsxc2A865V6');
    }
    /**
     * Generate new JWT token
     */
    public function encode(array $data): string
    {
        $issuedAt = time();
        $expire = $issuedAt + $this->expiration_in_seconds; // expiration time in seconds
 
        $tokenParam = [
            'iat'  => $issuedAt,            // timestamp from JWT generation
            'iss'  => $this->domain,      // domain from which the token was generated 
            'exp'  => $expire,              // token expiration (in seconds)
            'nbf'  => $issuedAt - 1,        // invalidate token 1 second before generation 
            'data' => $data, // data from user
        ];
 
        return JWT::encode($tokenParam, $this->key);
    }
 
    /**
     * Decode JWT token
     */
    public function decode(string $token): ?array
    {
        try {
            $decoded_token = JWT::decode($token, $this->key, ['HS256']);
        } catch (Exception $error) {
            return null;
        }
        if (is_object(($decoded_token->data))) {
            return (array) $decoded_token->data;
        }
    }
}