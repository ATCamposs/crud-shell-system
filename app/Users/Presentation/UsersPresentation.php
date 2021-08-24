<?php

declare(strict_types=1);

namespace app\Users\Presentation;

use app\Users\Services\UserService;
use support\Request;
use support\Response;

class UsersPresentation
{
    public function index(Request $request): Response
    {
        return json(200, UserService::index());
    }

    public function get(Request $request, int $id): Response
    {
        $user = userService::getFullUserData($id);
        if (empty($user)) {
            return json(400, [
                'status' => 'fail',
                'data' => ['id' => trans('Incorrect user id.')]
            ]);
        }
        return json(200, [
            'status' => 'success',
            'data' => ['user' => $user]
        ]);
    }

    public function update(Request $request): Response
    {
        if (!empty($request->input('username', ''))) {
            $new_data['username'] = $request->input('username');
        }
        if (!empty($request->input('email', ''))) {
            $new_data['email'] = $request->input('email');
        }
        if (!isset($new_data)) {
            return json(400, [
                'status' => 'fail',
                'data' => ['message' => trans('At least one field must be filled.')]
            ]);
        }
        global $user_from_request;
        $current_user_id = $user_from_request->id();
        $update_return = UserService::update($current_user_id, $new_data);
        if ($update_return['status'] === 'success') {
            return json(201, $update_return);
        }
        return json(400, $update_return);
    }

    public function updatePassword(Request $request): Response
    {
        $password = $request->input('password');
        $confirm_password = $request->input('confirmPassword');
        if (
            !isset($password)
            || !isset($confirm_password)
            || empty(trim($password))
            || empty(trim($confirm_password))
        ) {
            return json(400, [
                'status' => 'fail',
                'data' => ['message' => trans('Please fill in all required fields.')]
            ]);
        };
        global $user_from_request;
        $current_user_id = $user_from_request->id();
        $update_pass_return = UserService::updatePassword($current_user_id, $password, $confirm_password);
        if ($update_pass_return['status'] === 'success') {
            return json(200, $update_pass_return);
        }
        return json(400, $update_pass_return);
    }

    public function delete(Request $request, int $id): Response
    {
        if (!isset($id) || empty($id)) {
            return json(400, [
                'status' => 'fail',
                'data' => ['id' => trans('Please fill in all required fields.')]
            ]);
        };
        $delete_return = UserService::delete($id);
        if ($delete_return['status'] === 'success') {
            return json(201, $delete_return);
        }
        return json(400, $delete_return);
    }
}