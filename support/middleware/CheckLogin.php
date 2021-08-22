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
        global $user_from_request;
        if (empty($request->header('authorization'))) {
            return json(401, [
                'status' => 'fail',
                'message' => trans('You need to login to view this content.')
            ]);
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
        $user_from_request = $auth_user_data;
        return $next($request);
    }
}