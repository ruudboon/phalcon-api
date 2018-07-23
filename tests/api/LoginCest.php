<?php

namespace Niden\Tests\api;

use ApiTester;
use function json_decode;
use Niden\Exception\Exception;
use Niden\Http\Response;
use Niden\Models\Users;
use Page\Data;

class LoginCest
{
    public function loginUnknownUser(ApiTester $I)
    {
        $I->sendPOST(
            Data::$loginUrl,
            [
                'username' => 'user',
                'password' => 'pass',
            ]
        );
        $I->seeResponseIsSuccessful();
        $I->seeErrorJsonResponse('Incorrect credentials');
    }

    public function loginKnownUser(ApiTester $I)
    {
        $I->haveRecordWithFields(
            Users::class,
            [
                'status'   => 1,
                'username' => 'testuser',
                'password' => 'testpassword',
                'issuer'   => 'https://phalconphp.com',
                'tokenId'  => '110011',
            ]
        );

        $I->sendPOST(Data::$loginUrl, Data::loginJson());
        $I->seeResponseIsSuccessful();
        $response = $I->grabResponse();
        $data     = json_decode($response, true);
        $I->assertTrue(isset($data['data']));
        $I->assertTrue(isset($data['data']['token']));
        $I->assertTrue(isset($data['meta']));
    }
}
