<?php

namespace App\Services\BPMS2\Http\Controllers;

use App\Services\BPMS2\enums\HttpMethod;
use App\Services\BPMS2\Http\ProcessBaseClass;

class MicroProcessController extends ProcessBaseClass
{

    public function __construct()
    {
        $this->baseUrl = config('process.platform_base_url');
        $this->userPlatformAuth = session('platformToken') ?? null;
        $this->user = auth('web')->user();
        parent::__construct($this->baseUrl, $this->userPlatformAuth, $this->user->userName);
    }

    public function getCity(int $provinceId)
    {
        $getCitiesURL = str_replace(':process-instance-id', config('process.get_cities'), config('process.start_prcs_with_return'));
        $data = [
            'ProvinceId' => $provinceId
        ];
        $response = parent::method(HttpMethod::POST)->url($getCitiesURL)->data($data)->execute();
        $cities = [];
        if ($response->get('status') && $response->get('response')) {
            foreach ($response->get('response')->variables->details as $item) {
                if ($item->name == 'ListOfCities'){
                    $cities = json_decode($item->value);
                    break;
                }
            }
        }
        return [
          'status'=>$response->get('status'),
          'cities' =>$cities
        ];
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

    public function getUserProcesses($username,$password,$start = 0, $size = 50000, $order = 'asc'): array
    {
        $get_user_tasks = config('process.get_user_processes');
        $data = ['start' => $start, 'size' => $size, 'order' => $order];
        $headers = ['token' => $password, 'user' => $username, 'branch' => 'BR'];
        $response = parent::method(HttpMethod::GET)->url($get_user_tasks)->headers($headers)->params($data)->execute();
        return [
            'status' => $response->get('status'),
            'processes' => $response->get('response')->data ?? []
        ];
    }
}
