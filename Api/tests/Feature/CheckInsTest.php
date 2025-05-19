<?php

namespace Tests\Feature;

use App\Models\CheckIns;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckInsTest extends TestCase
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
        $userRole = UserRole::factory()->create();
        $user = User::factory()->create([
            'email' => 'john.doe2@example.com',
            'password' => $this->password,
            'role_id' => $userRole->id
        ]);

        CheckIns::factory()->create([
            'user_id' => $user->id,
        ]);

        $token = $this->login();

        $response = $this->getJson('/api/v1/checkIns',  [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'email' => 'john.doe2@example.com',
        ]);
    }

    public function test_show()
    {
        $userRole = UserRole::factory()->create();
        $user = User::factory()->create([
            'email' => 'john.doe2@example.com',
            'password' => $this->password,
            'role_id' => $userRole->id
        ]);

        $checkIns = CheckIns::factory()->create([
            'user_id' => $user->id,
        ]);

        $token = $this->login();

        $response = $this->getJson('/api/v1/checkIns/' . $checkIns->id,  [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'email' => 'john.doe2@example.com',
        ]);
    }

    public function test_show_not_found()
    {
        $token = $this->login();

        $response = $this->getJson('/api/v1/checkIns/1312',  [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(404);
    }

    public function test_show_staff()
    {
        $userRole = UserRole::factory()->create();
        $user = User::factory()->create([
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

        CheckIns::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/v1/checkIn/showStaff',  [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_store()
    {
        $token = $this->login();

        $data = [
            'check_in_time' => now()->toTimeString(),
            'check_out_time' => now()->addHours(4)->toTimeString(),
            'check_date' => now()->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/v1/checkIns',   $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(201);
    }

    public function test_store_check_out_less_than_check_in()
    {
        $token = $this->login();

        $data = [
            'check_in_time' => now()->toTimeString(),
            'check_out_time' => now()->subHours(4)->toTimeString(),
            'check_date' => now()->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/v1/checkIns',   $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(422);
    }

    public function test_update()
    {
        $userRole = UserRole::factory()->create();
        $user = User::factory()->create([
            'email' => 'john.doe2@example.com',
            'password' => $this->password,
            'role_id' => $userRole->id
        ]);

        $checkIns = CheckIns::factory()->create([
            'user_id' => $user->id,
        ]);

        $token = $this->login();

        $data = [
            'check_in_time' => now()->subHour()->toTimeString(),
        ];

        $response = $this->putJson('/api/v1/checkIns/' . $checkIns->id,  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'success']);
    }

    public function test_update_not_found()
    {
        $token = $this->login();

        $data = [
            'check_in_time' => now()->subHour()->toTimeString(),
        ];

        $response = $this->putJson('/api/v1/checkIns/1855',  $data, [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(404);
        $response->assertJson(['message' => 'checkins not found']);
    }
    public function test_delete()
    {
        $userRole = UserRole::factory()->create();
        $user = User::factory()->create([
            'email' => 'john.doe2@example.com',
            'password' => $this->password,
            'role_id' => $userRole->id
        ]);

        $checkIns = CheckIns::factory()->create([
            'user_id' => $user->id,
        ]);

        $token = $this->login();

        $response = $this->deleteJson('/api/v1/checkIns/' . $checkIns->id,  [], [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(204);
    }

    public function test_delete_not_found()
    {
        $token = $this->login();

        $response = $this->deleteJson('/api/v1/checkIns/1855',  [], [
            'Authorization' => "Bearer $token",
        ]);
        $response->assertStatus(404);
        $response->assertJson(['message' => 'checkins not found']);
    }
}
