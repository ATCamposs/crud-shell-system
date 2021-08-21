<?php

declare(strict_types=1);

namespace app\Users\Domain\ValueObjects;

class Username
{
    private string $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return Username|array;
     */
    public static function validate(string $username)
    {
        $errors = [];
        if (preg_match('/^(?=.*[\\s])/', $username)) {
            $errors[] = trans('Your username cannot have whitespaces.');
        }
        if (strlen($username) < 3) {
            $errors[] = trans('Your username must be at least 3 characters.');
        }
        if (strlen($username) > 25) {
            $errors[] = trans('Your username must be less than 26 characters.');
        }
        if (!preg_match('/^[A-z]+$/m', $username)) {
            $errors[] = trans('Your username cannot have special characters.');
        }
        if (count($errors) > 0) {
            return $errors;
        }
        return new Username($username);
    }

    public function __toString(): string
    {
        return $this->username;
    }
}