<?php

declare(strict_types=1);

namespace app\Users\Domain\ValueObjects;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return Password|array;
     */
    public static function validate(string $password) {
        $errors = [];
        if (preg_match('/^(?=.*[\\s])/', $password)) {
            $errors[] = trans('Your password cannot have whitespaces.');
        }
        if (strlen($password) < 6) {
            $errors[] = trans('Your password must be at least 6 characters.');
        }
        if (strlen($password) > 14) {
            $errors[] = trans('Your password must be less than 15 characters.');
        }
        if (!preg_match('/^(?=.*[a-z])/', $password)) {
            $errors[] = trans('Your password must contain at least 1 lowercase.');
        }
        if (!preg_match('/^(?=.*[A-Z])/', $password)) {
            $errors[] = trans('Your password must contain at least 1 uppercase.');
        }
        if (!preg_match('/^(?=.*[0-9])/', $password)) {
            $errors[] = trans('Your password must contain at least 1 number.');
        }
        if (count($errors) > 0) {
            return $errors;
        }
        return new Password($password);
    }

    public function __toString(): string
    {
        return $this->password;
    }
}