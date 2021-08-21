<?php

declare(strict_types=1);

namespace app\Users\Domain;

use app\Users\Domain\ValueObjects\Email;
use app\Users\Domain\ValueObjects\Password;
use app\Users\Domain\ValueObjects\Username;
use app\Users\Infrastructure\UserRepositoryIlluminate;

class User
{
    private int $id;
    private Username $username;
    private Email $email;
    private Password $password;

    public function __construct(
        int $id,
        Username $username,
        Email $email,
        Password $password
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function update(array $new_data): array
    {
        $return_message = [];
        if (isset($new_data['username'])) {
            if ((string) $this->username === $new_data['username']) {
                return [
                    'status' => 'fail',
                    'data' => ['username' => trans('The new username is the same as the old username.')]
                ];
            }
            $username = Username::validate($new_data['username']);
            if (is_array($username)) {
                return ['status' => 'fail', 'data' => ['username' => $username]];
            }
            if ($this->getRepository()->checkUsernameInUse($username)) {
                return ['status' => 'fail', 'data' => ['username' => trans('The username is already in use')]];
            };
            $return_message['username'] = trans('Username updated successfully.');
        }
        if (isset($new_data['email'])) {
            if ((string) $this->email === $new_data['email']) {
                return ['status' => 'fail', 'data' => ['email' => trans('The new email is the same as the old email.')]];
            }
            $email = Email::validate($new_data['email']);
            if(is_array($email)) {
                return ['status' => 'fail', 'data' => ['email' => $email]];
            }
            if ($this->getRepository()->checkEmailInUse($email)) {
                return ['status' => 'fail', 'data' => ['email' => trans('This email already in use.')]];
            };
            $return_message['email'] = trans('Email updated successfully.');
        }

        if ($this->getRepository()->updateUser($this->id, $new_data)) {
            return ['status' => 'success', 'data' => $return_message];
        }
        return ['status' => 'fail', 'data' => ['message' => trans('Error, please try again.')]];
    }

    public function password(): Password
    {
        return $this->password;
    }

    public function updatePassword(string $password, string $confirm_password): array
    {
        if ($password !== $confirm_password) {
            return ['status' => 'fail', 'data' => ['password' => trans('The 2 passwords must be the same.')]];
        }
        $this->password = Password::validate($password);
        if (is_array($this->password)) {
            return ['status' => 'fail', 'data' => ['password' => $password]];
        }
        if ($this->getRepository()->updatePassword($this->id, $this->password)) {
            return ['status' => 'success', 'data' => ['password' => trans('Password updated successfully.')]];
        }
        return ['status' => 'fail', 'data' => ['message' => trans('Error, please try again.')]];
    }

    protected function getRepository(): UserRepositoryInterface
    {
        return new UserRepositoryIlluminate();
    }
}