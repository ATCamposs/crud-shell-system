<?php

declare(strict_types=1);

namespace app\Users\Domain;

use app\Users\Domain\ValueObjects\Username;
use app\Users\Domain\ValueObjects\Email;
use app\Users\Domain\ValueObjects\Password;

interface UserRepositoryInterface
{
    public function index(): ?object;
    public function getFullUserData(int $id): ?object;
    public function getUserByID(int $id): ?object;
    public function getUserByEmail(Email $email): ?object;
    public function checkEmailInUse(Email $email, int $id): bool;
    public function checkUsernameInUse(Username $username, int $id): bool;
    public function updateUser(int $id, array $new_data): bool;
    public function updatePassword(int $id, Password $password): bool;
    public function register(Username $username, Email $email, Password $password): bool;
    public function delete(int $id): bool;
}