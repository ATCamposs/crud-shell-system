<?php

declare(strict_types=1);

namespace app\Users\Infrastructure;

use app\Users\Domain\UserRepositoryInterface;
use app\Users\Domain\ValueObjects\Email;
use app\Users\Domain\ValueObjects\Username;
use app\Users\Domain\ValueObjects\Password;
use DateTime;
use PDOException;
use support\bootstrap\Log;
use support\Db;

class UserRepositoryIlluminate implements UserRepositoryInterface
{
    private Db $illuminteDB;

    public function __construct()
    {
        $this->illuminteDB = new Db();
    }

    public function index(): ?object
    {
        $users_table = $this->illuminteDB::table('users');
        try {
            return $users_table->select('id', 'username', 'email', 'created')->get();
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return null;
        };
    }

    public function getFullUserData(int $id): ?object
    {
        $users_table = $this->illuminteDB::table('users');
        try {
            return $users_table->where('id', $id)->first();
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return null;
        }
    }

    public function getUserByID(int $id): ?object
    {
        $users_table = $this->illuminteDB::table('users');
        try {
            $selected_activation_hash = $users_table->where('id', $id);
            return $selected_activation_hash->first(['id', 'username', 'email', 'password']);
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return null;
        };
    }

    public function getUserByEmail(Email $email): ?object
    {
        $users_table = $this->illuminteDB::table('users');
        try {
            $selected_email = $users_table->where('email', $email);
            return $selected_email->first(['id', 'username', 'email', 'password']);
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return null;
        };
    }

    public function checkUsernameInUse(Username $username, int $id = 0): bool
    {
        $users_table = $this->illuminteDB::table('users');
        try {
            $selected_username = $users_table->select('id', 'username');
            $username = $selected_username->where('username', $username);
            $user = $username->first();
            if (!empty($user) && $user->id != $id) {
                return true;
            }
            return false;
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return false;
        };
    }

    public function checkEmailInUse(Email $email, int $id = 0): bool
    {
        $users_table = $this->illuminteDB::table('users');
        try {
            $selected_email = $users_table->select('id', 'email');
            $user_email = $selected_email->where('email', $email);
            $user = $user_email->first();
            if (!empty($user) && $user->id != $id) {
                return true;
            }
            return false;
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return false;
        };
    }

    public function updateUser(int $id, array $new_data): bool
    {
        $now = new DateTime();
        $users_table = $this->illuminteDB::table('users');
        try {
            $selected_user = $users_table->where('id', $id);
            $new_data['updated'] = $now;
            if ($selected_user->update($new_data)) {
                return true;
            };
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return false;
        };
        return false;
    }

    public function updatePassword(int $id, Password $password): bool
    {
        $now = new DateTime();
        $users_table = $this->illuminteDB::table('users');
        try {
            $selected_user = $users_table->where('id', $id);
            if ($selected_user->update([
                'password' => password_hash((string) $password, PASSWORD_DEFAULT), 
                'updated' => $now
                ])) {
                return true;
            };
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return false;
        };
        return false;
    }

    public function register(Username $username, Email $email, Password $password): bool {
        $users_table = $this->illuminteDB::table('users');
        $now = new DateTime();
        try {
            return $users_table->insert([
                'username' => $username,
                'email' => $email,
                'password' => password_hash((string) $password, PASSWORD_DEFAULT),
                'created' => $now
            ]);
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return false;
        };
    }

    public function delete(int $id): bool
    {
        $users_table = $this->illuminteDB::table('users');
        $selected_user = $users_table->where('id', $id);
        try {
            if ($selected_user->delete()) {
                return true;
            };
        } catch (PDOException $error) {
            Log::error($error->getMessage());
            return false;
        };
        return false;
    }
}