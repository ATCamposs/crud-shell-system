<?php

declare(strict_types=1);

namespace app\Users\Domain\ValueObjects;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
    
    /**
     * @return Email|array;
     */
    public static function validate(string $email) {
        $errors = [];
        if (preg_match('/^(?=.*[\\s])/', $email)) {
            $errors[] = trans('Your email cannot have whitespaces.');
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = trans('Invalid email address.');
        }
        if (count($errors) > 0) {
            return $errors;
        }
        return new Email($email);
    }

    public function __toString(): string
    {
        return $this->email;
    }
}