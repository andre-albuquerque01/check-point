<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
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

    public function test_index()
    {
        UserRole::factory()->create([
            'role' => 'ADMIN',
        ]);

        $token = $this->login();

        $response = $this->getJson('/api/v1/role',  [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'role' => 'ADMIN',
        ]);
    }

    public function test_show()
    {
        $role = UserRole::factory()->create([
            'role' => 'ADMIN',
        ]);

        $token = $this->login();

        $response = $this->getJson('/api/v1/role/' . $role->id,  [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'role' => 'ADMIN',
        ]);
    }

    public function test_show_not_found()
    {
        $token = $this->login();

        $response = $this->getJson('/api/v1/role/1312',  [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(404);
    }

    public function test_store()
    {
        $token = $this->login();

        $data = [
            'role' => 'staff',
            'description' => 'funcionario melhorzinho',
        ];

        $response = $this->postJson('/api/v1/role',   $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(201);
    }

    public function test_update()
    {
        $role = UserRole::factory()->create([
            'role' => 'ADMIN',
        ]);

        $data = [
            'role' => 'employees',
        ];

        $token = $this->login();

        $response = $this->putJson('/api/v1/role/' . $role->id,  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'success']);
    }

    public function test_update_not_found()
    {
        $token = $this->login();

        $data = [
            'role' => 'employees',
        ];

        $response = $this->putJson('/api/v1/role/1855',  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(404);
        $response->assertJson(['message' => 'role not found']);
    }
    public function test_delete()
    {
        $role = UserRole::factory()->create([
            'role' => 'ADMIN',
        ]);

        $token = $this->login();

        $response = $this->deleteJson('/api/v1/role/' . $role->id,  [], [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(204);
    }

    public function test_delete_not_found()
    {
        $token = $this->login();

        $response = $this->deleteJson('/api/v1/role/1855',  [], [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(404);
        $response->assertJson(['message' => 'role not found']);
    }
}
