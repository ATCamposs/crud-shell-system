<?php

namespace support\middleware;

use app\Users\Infrastructure\Authentication\Tokenization\JWTTokenization;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class CheckLogin implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        $session = $request->session();
        $user = $session->get('user');
        if ($user) {
            return $next($request);
        }
        $token = explode(" ", trim($request->header('authorization')))[1];
        if ($token === 'undefined' || empty(trim($token))) {
            return json(401, [
                'status' => 'fail',
                'message' => trans('You need to login to view this content.')
            ]);
        }
        $auth_user_data = (new JWTTokenization())->decode($token);
        if (empty($auth_user_data)) {
            return json(401, [
                'status' => 'fail',
                'message' => trans('Please login again.')
            ]);
        }
        $session->set('user', $auth_user_data);
        return $next($request);
    }
}