<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\FunctionsForTests;
use App\Enums;


class AuthControllerTests extends TestCase
{
    /**
     * 1.
     */
    public function test_GetUserApiJson_ReturnJson_Success()
    {
        FunctionsForTests::createOneUsers();
        $response = $this->get('api/v1/auth/login?email=email@email.com&password=123');
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
        FunctionsForTests::delUser();
    }

    public function test_GetUserApiJson_NotFound()
    {
        $response = $this->get('api/v1/auth/login?email=email&password=123');
        $response->assertStatus(404);
    }

    /**
     * 2.
     * */
    public function test_FindUserApi_Success()
    {
        FunctionsForTests::createOneUsers();
        $response = $this->get('api/v1/auth/logout/1234');
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
        FunctionsForTests::delUser();
    }

    public function test_FindUserApi_NotFound()
    {
        $response = $this->get('api/v1/auth/logout/1234');
        $response->assertStatus(404);
    }

    /**
     * 3.
     * */

    public function test_Role_Admin()
    {
        FunctionsForTests::createOneUsers('Admin');
        $response = $this->get('api/v1/users?api_token=1234');
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
        FunctionsForTests::delUser();
    }

    public function test_Role_NotAdmin()
    {
        FunctionsForTests::createOneUsers();
        $response = $this->get('api/v1/users?api_token=1234');
        $response->assertStatus(403);
        FunctionsForTests::delUser();
    }

    /**
     * 4.
     * */
    public function test_UpdateInfoUser_Admin()
    {
        FunctionsForTests::createOneUsers('Admin');
        $user = FunctionsForTests::createOneUsers('', 'Alex', 'asda@email.com', 'asdasd');
        $response = $this->patch("api/v1/user/$user->id?name=1231&role=Admin&banned=0&api_token=1234");
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
        FunctionsForTests::delUser();
        FunctionsForTests::delUser(1231);
    }
}
