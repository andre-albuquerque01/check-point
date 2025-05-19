<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login()
    {
        $userRole = UserRole::factory()->create();
        User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => 'strongPassword@1231254124',
            'role_id' => $userRole->id
        ]);

        $credentials = [
            'email' => 'john.doe@example.com',
            'password' => 'strongPassword@1231254124',
        ];

        $response = $this->post('/api/v1/user/sessions', $credentials);
        $response->assertStatus(200);
    }

    public function test_login_with_wrong_crendials()
    {
        $userRole = UserRole::factory()->create();
        User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => 'strongPassword@1231254124',
            'role_id' => $userRole->id
        ]);

        $credentials = [
            'email' => 'john.do1e@example.com',
            'password' => 'strong1Password@1231254124',
        ];

        $response = $this->post('/api/v1/user/sessions', $credentials);
        $response->assertStatus(401)->assertJson(['message' => 'E-mail or password invalid']);
    }
}
