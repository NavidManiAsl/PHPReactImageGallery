<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{User, Image, Gallery};
use Illuminate\Http\UploadedFile;

use function PHPUnit\Framework\assertGreaterThan;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_return_401_to_guest_call()
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
        auth()->logout();
    }

    public function test_show_method_return_401_to_guest_call()
    {
        $image = Image::factory()->create();
        $response = $this->get('/api/v1/images/' . $image->id);
        $response->assertStatus(401);
    }

    public function test_show_method_show_an_Image()
    {
        $user = User::factory()->create();
        auth()->login($user);
        $image = Image::factory()->create(['user_id' => $user->id]);
        $response = $this->get('/api/v1/images/' . $image->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [],
        ]);

        auth()->logout();
    }
    public function test_show_method_show_user_image_to_authorized_call()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $imageA = Image::factory()->create(['user_id' => $userA->id]);
        $imageB = Image::factory()->create(['user_id' => $userB->id]);
        auth()->login($userA);

        $response = $this->get('/api/v1/images/' . $imageB->id);
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'status',
            'message',

        ]);

        auth()->logout();

    }

    public function test_store_method_return_401_to_guest_call()
    {

        $response = $this->post(
            '/api/v1/images',
            [
                'name' => 'test',
                'image' => UploadedFile::fake()->image('test.jpg')
            ]
        );
        $response->assertStatus(401);
    }

    public function test_store_method_store_an_image()
    {
        $user = User::factory()->create(['id' => 1]);
        Gallery::factory()->create(['id' => 1]);
        auth()->login($user);


        $testImagePath = storage_path('/../tests/test.jpg');
        $response = $this->withHeaders(['bearer' => $user->currentAccessToken()])->post('/api/v1/images', [
            'name' => 'test',
            'description' => 'test',
            'tags' => 'a:3:{i:0;s:3:"Red";i:1;s:5:"Green";i:2;s:4:"Blue";}',
            'image' => new UploadedFile($testImagePath, 'test.jpg', 'image/jpeg', null, true),
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Image has been successfully uploaded']);

    }

    public function test_authorized_user_can_add_tags_to_an_image()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $image1 = Image::factory()->create(['user_id' => $user->id, 'tags' => null]);
        $image2 = Image::factory()->create(['user_id' => 3]);
        $response = $this->post('/api/v1/images/' . $image1->id . '/tags', [
            'tags' => 'a:3:{i:0;s:3:"Red";i:1;s:5:"Green";i:2;s:4:"Blue";}'
        ]);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Tags has been successfully updated']);
        $image1->refresh();
        assertGreaterThan(1, count($image1->tags));
        $response = $this->post('/api/v1/images/' . $image2->id . '/tags', [
            'tags' => 'a:3:{i:0;s:3:"Red";i:1;s:5:"Green";i:2;s:4:"Blue";}'
        ]);
        $response->assertStatus(401)->assertJsonFragment(['message' => 'Unauthorized']);
    }
}
