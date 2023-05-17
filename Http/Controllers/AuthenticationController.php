<?php

namespace App\Services\BPMS2\Http\Controllers;

use App\Services\BPMS2\enums\HttpMethod;
use App\Services\BPMS2\Http\ProcessBaseClass;

class AuthenticationController extends ProcessBaseClass
{

    public function __construct()
    {
        parent::__construct(config('process.login_base_url'));
        parent::setErrorMSG(config('نام کاربری و رمز عبور مطابقت ندارد'));
    }

    public function login(string $userName, string $password): array
    {
        $data = [
            'userName' => $userName,
            'password' => $password,
        ];
        $header = ["Accept" => "*/*"];
        $response = parent::method(HttpMethod::POST)->url('auth/login')->data($data)->headers($header)->execute();
        return $response->toArray();
    }
}
