<?php

declare(strict_types=1);

namespace app\Users\Presentation;

use app\Users\Services\AuthenticationService;
use support\Request;
use support\Response;

class AuthenticationPresentation
{
    public function __construct()
    {
        $this->auth_services = new AuthenticationService();
    }

    public function login(Request $request): Response
    {
        $email = $request->input('email');
        $password = $request->input('password');
        if (
            !isset($email)
            || !isset($password)
            || empty(trim($email))
            || empty(trim($password))
        ) {
            return json(400, [
                'status' => 'fail',
                'data' => ['message' => trans('Please fill in all required fields.')]
            ]);
        };
        $login_return = $this->auth_services->login($email, $password);
        if ($login_return['status'] === 'success') {
            return json(200, $login_return);
        }
        return json(400, $login_return);
    }

    public function register(Request $request): Response
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $confirm_password = $request->input('confirmPassword');
        if (
            !isset($username)
            || !isset($email)
            || !isset($password)
            || !isset($confirm_password)
            || empty(trim($username))
            || empty(trim($email))
            || empty(trim($password))
            || empty(trim($confirm_password))
        ) {
            return json(400, [
                'status' => 'fail',
                'data' => ['message' => trans('Please fill in all required fields.')]
            ]);
        };
        $register_return = $this->auth_services->register(
            $username,
            $email,
            $password,
            $confirm_password
        );
        if ($register_return['status'] === 'success') {
            return json(201, $register_return);
        }
        return json(400, $register_return);
    }
}