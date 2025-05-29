<?php

namespace Tests\Feature;

use App\Enum\PermissionEnum;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $password = 'strongPassword@1231254124';

    public function login()
    {
        $userRole = UserRole::factory()->create();
        User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => $this->password,
            'role_id' => $userRole->id
        ]);

        $credentials = [
            'email' => 'john.doe@example.com',
            'password' => $this->password,
        ];

        $loginResponse = $this->postJson('/api/v1/user/sessions', $credentials);

        $token = $loginResponse->json('token');

        return $token;
    }

    public function test_register()
    {
        $userRole = UserRole::factory()->create();
        $data = [
            "name" => "John doe",
            "email" => "john.doe@example.com",
            "password" => $this->password,
            "password_confirmation" => $this->password,
            'role_id' => $userRole->id,
            'permission' => PermissionEnum::VIEWER->value,
        ];

        $response = $this->post('/api/v1/user/register', $data);
        $response->assertStatus(201);
    }

    public function test_register_wrong_password()
    {
        $userRole = UserRole::factory()->create();
        $data = [
            'name' => 'John doe',
            'email' => 'john.doe@example.com',
            'password' => $this->password,
            'password_confirmation' => 'strongPassword1@1231254124',
            'role_id' => $userRole->id,
        ];

        $response = $this->post('/api/v1/user/register', $data);
        $response->assertStatus(302);
    }

    public function test_show()
    {
        $token = $this->login();

        $response = $this->getJson('/api/v1/user/me',  [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_update()
    {
        $token = $this->login();

        $data = [
            'email' => 'john.doe2@example.com',
            'password' => $this->password,
        ];

        $response = $this->putJson('/api/v1/user/update',  $data, [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'success']);
    }

    public function test_update_with_wrong_password()
    {
        $token = $this->login();

        $data = [
            'email' => 'john.doe2@example.com',
            'password' => "asdsa" . $this->password,
        ];

        $response = $this->putJson('/api/v1/user/update',  $data, [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'password incorrect']);
    }

    public function test_update_password()
    {
        $token = $this->login();

        $data = [
            'password_old' => $this->password,
            'password' => $this->password . '1',
            'password_confirmation' => $this->password . '1',
        ];

        $response = $this->putJson('/api/v1/user/update/password',  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(201)
            ->assertJson(['message' => 'success']);
    }

    public function test_update_password_with_wrong_password()
    {
        $token = $this->login();

        $data = [
            'password_old' => $this->password . '22',
            'password' => $this->password . '1',
            'password_confirmation' => $this->password . '1',

        ];

        $response = $this->putJson('/api/v1/user/update/password',  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(401)
            ->assertJson(['message' => 'password incorrect']);
    }

    public function test_update_role()
    {
        $userRole = UserRole::factory()->create();
        $token = $this->login();
        $user = User::factory()->create([
            'email' => 'john.doe2@example.com',
            'password' => $this->password,
            'role_id' => $userRole->id
        ]);

        $data = [
            'role_id' => $userRole->id
        ];

        $response = $this->putJson('/api/v1/user/update/role/' . $user->id,  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(201)
            ->assertJson(['message' => 'success']);
    }

    public function test_update_role_with_wrong_user()
    {
        $userRole = UserRole::factory()->create();
        $token = $this->login();

        $data = [
            'role_id' => $userRole->id
        ];

        $response = $this->putJson('/api/v1/user/update/role/14',  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(404);
    }
    public function test_update_permission()
    {
        $userRole = UserRole::factory()->create();
        $token = $this->login();
        $user = User::factory()->create([
            'email' => 'john.doe2@example.com',
            'password' => $this->password,
            'role_id' => $userRole->id
        ]);

        $data = [
            'permission' => PermissionEnum::ADMIN
        ];

        $response = $this->putJson('/api/v1/user/update/permission/' . $user->email,  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(201)
            ->assertJson(['message' => 'success']);
    }

    public function test_update_permission_with_wrong_user()
    {
        $userRole = UserRole::factory()->create();
        $token = $this->login();

        $data = [
            'permission' => PermissionEnum::ADMIN
        ];

        $response = $this->putJson('/api/v1/user/update/permission/54545',  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(404);
    }
}
