<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_register_a_user(): void
    {
        $response = $this->postJson('/api/v1/register',[
            'name' =>'john doe',
            'email' =>'john@doe.com',
            'password'=> 'password',
            'password_confirmation' =>'password'
        ]);

        $response
            ->assertSuccessful()
            ->assertjson([
                "status"=> "ok",
                "message"=>null,
                "data"=>[
                    "user"=> [
                        "id"=> 1,
                        "name"=> "john doe",
                        "email"=> "john@doe.com",
                    
                    ],
                    
                ]
            ])->assertJsonStructure([
                'status',
                'message',
                'data'=>[
                    'user'=> [
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
