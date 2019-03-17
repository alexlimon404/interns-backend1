<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\FunctionsForTests;

class UserControllerTests extends TestCase
{
    /**
     * 1.Роут
     *
     */

    public function test_addGroup_ReturnJson ()
    {
        $str_random = str_random(10);
        $response = $this->post("api/v0/users/group?name=Group - $str_random", ['success' => true]);
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
    }
    /**
     * 2.
     * */

    public function test_getGroupsUser_ReturnJson ()
    {
        FunctionsForTests::createUsers(3);
        FunctionsForTests::createGroups(3);
        FunctionsForTests::createGroupsForUsers(3);
        $response = $this->get('api/v0/user/2/groups');
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);

    }
    /**
     *
     * */

    public function test_delGroup_ReturnJson ()
    {
        FunctionsForTests::createGroups(3);
        $response = $this->delete('api/v0/users/groups/2');
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
    }

    public function test_addUserInGroup_ReturnJson ()
    {
        FunctionsForTests::createUsers(3);
        FunctionsForTests::createGroups(3);
        $response = $this->post('api/v0/user/1/group/3');
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
    }

    public function test_delUserInGroup ()
    {
        FunctionsForTests::createUsers(3);
        FunctionsForTests::createGroups(3);
        FunctionsForTests::createGroupsForUsers(3);
        $response = $this->delete('api/v0/user/1/group/1');
        $response->assertStatus(200);
        $response->assertJson(["success" => true]);
    }

}
