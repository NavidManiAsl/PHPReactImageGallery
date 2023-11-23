<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{User, Image};


class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_send_401_to_guest_call()
    {
        $response = $this->get("/api/v1/images");
        $response->assertStatus(401);
    }

    public function test_index_method_show_user_images()
    {
        $user = User::factory()->create();
        auth()->login($user);
        $response = $this->get("/api/v1/images");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
        auth()->logout();

    }

    public function test_index_method_show_user_images_to_authorized_call()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $imageA = Image::factory()->create(['user_id' => $userA->id]);
        $imageB = Image::factory()->create(['user_id' => $userB->id]);

        auth()->login($userA);
        $response = $this->get('/api/v1/images');
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($imageA->id, $data['data'][0]['id']);
        $this->assertNotEquals($imageB->id, $data['data'][0]['id']);
    }
}
