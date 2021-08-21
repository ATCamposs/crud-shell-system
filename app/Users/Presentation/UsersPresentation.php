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

    public function update(Request $request): Response
    {
        if (!empty($request->input('username', ''))) {
            $new_data['username'] = $request->input('username');
        }
        if (!empty($request->input('email', ''))) {
            $new_data['email'] = $request->input('email');
        }
        $id = $request->session()->get('user')['id'];
        $update_return = UserService::update($id, $new_data);
        if ($update_return['status'] === 'success') {
            return json(201, $update_return);
        }
        return json(400, $update_return);
    }

    public function delete(Request $request, int $id): Response
    {
        $session = $request->session();
        $session_id = $session->get('user')['id'];
        if (!isset($id) || empty($id)) {
            return json(400, [
                'status' => 'fail',
                'data' => ['id' => trans('Please fill in all required fields.')]
            ]);
        };
        if ($session_id != $id) {
            return json(400, [
                'status' => 'fail',
                'data' => ['id' => trans('Incorrect user id.')]
            ]);
        }
        $session->delete('user');
        $delete_return = $this->auth_services->delete($id);
        if ($delete_return['status'] === 'success') {
            return json(201, $delete_return);
        }
        return json(400, $delete_return);
    }
}