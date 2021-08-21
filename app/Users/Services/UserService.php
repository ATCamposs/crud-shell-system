<?php

declare(strict_types=1);

namespace app\Users\Services;

use app\Users\Domain\User;
use app\Users\Domain\ValueObjects\Email;
use app\Users\Domain\ValueObjects\Password;
use app\Users\Domain\ValueObjects\Username;
use app\Users\Infrastructure\UserRepositoryIlluminate;

class UserService
{
    public static function index()
    {
        $all_users = (new UserRepositoryIlluminate())->index();
        if(empty($all_users)) {
            return ['status' => 'fail', 'message' => 'No users found.'];
        }
        return ['status' => 'success', 'data' => ['users' => $all_users]];
    }

    public static function register(string $username, string $email, string $password): array
    {
        $username = Username::validate($username);
        $email = Email::validate($email);
        $password = Password::validate($password);
        $return = ['status' => 'fail'];
        if (is_array($username)) {
            $return['data']['username'] = $username;
        }
        if (is_array($email)) {
            $return['data']['email'] = $email;
        }
        if (is_array($password)) {
            $return['data']['password'] = $password;
        }
        if (isset($return['data'])) {
            return $return;
        }
        if ((new UserRepositoryIlluminate())->checkEmailInUse($email)) {
            return ['status' => 'fail', 'data' => ['email' => trans('This email already in use.')]];
        };
        if ((new UserRepositoryIlluminate())->register($username, $email, $password)) {
            return ['status' => 'success', 'data' => ['message' => trans('You have successfully registered.')]];
        }
        return ['status' => 'fail', 'data' => ['message' => trans('User cannot be registered, please try again.')]];
    }

    public static function getByID(int $id): ?User
    {
        $user_from_db = (new UserRepositoryIlluminate())->getUserByID($id);
        if (empty($user_from_db)) {
            return null;
        }
        return new User($id, new UserName($user_from_db->username), new Email($user_from_db->email), new Password($user_from_db->password));
    }

    public static function getByEmail(Email $email): ?User
    {
        $user_from_db = (new UserRepositoryIlluminate())->getUserByEmail($email);
        if (empty($user_from_db)) {
            return null;
        }
        return new User($user_from_db->id, new UserName($user_from_db->username), new Email($user_from_db->email), new Password($user_from_db->password));
    }

    public static function update(int $id, array $new_data)
    {
        $user = UserService::getByID($id);
        return $user->update($new_data);
    }

    public static function delete(int $id): array
    {
        if ((new UserRepositoryIlluminate())->delete($id)) {
            return [
                'status' => 'success',
                'data' => ['message' => trans('User successfully removed.')]
            ];
        }
        return [
            'status' => 'fail',
            'data' => ['message' => trans('Invalid User.')]
        ];
    }
}