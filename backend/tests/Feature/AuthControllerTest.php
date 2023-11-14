<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Summary of test_user_can_register_a_user
     * @return void
     */
    public function test_user_can_register_a_user(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'john doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response
            ->assertSuccessful()
            ->assertjson([
                "status" => "ok",
                "message" => null,
                "data" => [
                    "user" => [
                        "id" => 1,
                        "name" => "john doe",
                        "email" => "john@doe.com",

                    ],

                ]
            ])->assertJsonStructure([
                    'status',
                    'message',
                    'data' => [
                        'user' => [
                            'id',
                            'name',
                            'email',
                            'created_at',
                            'updated_at',
                        ],
                        'token'
                    ]
                ]);
    }

    /**
     * Summary of test_registered_user_can_login_with_access_token
     * @return void
     */
    public function test_registered_user_can_login_with_access_token(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                    'token'
                ]
            ]);
    }


}
