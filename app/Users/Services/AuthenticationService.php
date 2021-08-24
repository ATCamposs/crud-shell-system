<?php

declare(strict_types=1);

namespace app\Users\Services;

use app\Users\Domain\ValueObjects\Email;
use app\Users\Domain\ValueObjects\Password;
use app\Users\Infrastructure\Authentication\Tokenization\JWTTokenization;
use app\Users\Infrastructure\Authentication\Tokenization\TokenizationInterface;
use app\Users\Infrastructure\UserRepositoryIlluminate;

class AuthenticationService
{
    private TokenizationInterface $jwt_tokenization;

    public function __construct()
    {
        $this->jwt_tokenization = new JWTTokenization();
        $this->user_repository = new UserRepositoryIlluminate();
    }

    public function login(string $email, string $password): array
    {
        $email = Email::validate($email);
        if (is_array($email)) {
            return ['status' => 'fail', 'data' => ['email' => $email]];
        }
        $password = Password::validate($password);
        if (is_array($password)) {
            return ['status' => 'fail', 'data' => ['password' => $password]];
        }
        $user = UserService::getByEmail($email);
        if (empty($user)) {
            return ['status' => 'fail', 'data' => ['email' => trans('User not found.')]];
        }
        if (password_verify((string) $password, (string) $user->password())) {
            $token = $this->jwt_tokenization->encode(['id' => $user->id(), 'username' => (string) $user->username()]);
            return [
                'status' => 'success', 'data' => [
                    'id' => (int) $user->id(),
                    'username' => (string) $user->username(),
                    'email' => (string) $user->email(),
                    'token' => $token,
                ]
            ];
        };
        return ['status' => 'fail', 'data' => ['password' => trans('Invalid Password.')]];
    }

    public function register(string $username, string $email, string $password, string $confirm_password): array
    {
        if ($password !== $confirm_password) {
            return ['status' => 'fail', 'data' => [
                'password' => 'The 2 passwords must be the same.',
                'confirm_password' => 'The 2 passwords must be the same.'
            ]];
        }
        return UserService::register($username, $email, $password);
    }
}
