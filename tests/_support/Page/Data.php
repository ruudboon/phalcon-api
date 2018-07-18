<?php

namespace Page;

class Data
{
    public static $companiesUrl       = '/companies';
    public static $loginUrl           = '/login';
    public static $individualTypesUrl = '/individualtypes';
    public static $productTypesUrl    = '/producttypes';
    public static $usersUrl           = '/users';
    public static $wrongUrl           = '/sommething';

    public static function loginJson()
    {
        return json_encode(
            [
                'data' => [
                    'username' => 'testuser',
                    'password' => 'testpassword',
                ]
            ]
        );
    }

    public static function usersGetJson($userId = 0)
    {
        $payload = [
            'data' => [],
        ];

        if ($userId > 0) {
            $payload['data']['userId'] = $userId;
        }

        return json_encode($payload);
    }

    public static function companyAddJson($name, $address = '', $city = '', $phone = '')
    {
        return json_encode(
            [
                'data' => [
                    'name'    => $name,
                    'address' => $address,
                    'city'    => $city,
                    'phone'   => $phone,
                ]
            ]
        );
    }
}
