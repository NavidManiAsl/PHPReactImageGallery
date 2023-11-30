<?php

namespace Tests\Feature;

use App\Models\{Gallery, Image};
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_authenticated_user_can_create_a_gallery()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/v1/galleries', [
            'name' => 'test',
        ]);
        $response->assertStatus(401)->assertJsonFragment(['message' => 'Unauthenticated']);
        $this->actingAs($user);
        $response = $this->post('/api/v1/galleries', [
            'name' => 'test',
        ]);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Gallery has been created successfully']);
    }

    public function test_authorized_user_can_see_all_galleries()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Gallery::factory()->create(['user_id' => $user->id]);
        Gallery::factory()->create();
        $response = $this->get('/api/v1/galleries');
        $response->assertStatus(200)->assertJsonFragment(['message' => 'ok']);
        $data = json_decode($response->getContent());
        $this->assertEquals(count($data->data), 1);

    }

    public function test_authorized_user_can_see_a_gallery()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $gallery1 = Gallery::factory()->create(['user_id' => $user->id]);
        $gallery2 = Gallery::factory()->create();
        $response = $this->get('/api/v1/galleries/' . $gallery1->id);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'ok']);
        $response = $this->get('/api/v1/galleries/' . $gallery2->id);
        $response->assertStatus(401)->assertJsonFragment(['message' => 'Unauthorized']);
    }

    public function test_authorized_user_can_delete_a_gallery()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $gallery1 = Gallery::factory()->create(['user_id' => $user->id]);
        $gallery2 = Gallery::factory()->create();
        $response = $this->delete('/api/v1/galleries/' . $gallery1->id);
        $response->assertStatus(200)->assertJson([
            'status' => 'ok',
            'message' => 'Gallery has been successfully deleted',
            'data' => null,
        ]);
        $this->assertNull(Gallery::find($user->id));

        $response = $this->delete('/api/v1/galleries/' . $gallery2->id);
        $response->assertStatus(401)->assertJsonFragment(['message' => 'Unauthorized']);

    }

    public function test_authorized_user_can_add_an_image_to_a_gallery()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $image = Image::factory()->create(['user_id' => $user->id]);
        $gallery1 = Gallery::factory()->create(['user_id' => $user->id, 'images' => null]);
        $gallery2 = Gallery::factory()->create();
        $response = $this->post('/api/v1/galleries/' . $gallery1->id, [
            'images' => json_encode([$image->id])
        ]);
        $response->assertStatus(200)->assertJson([
            'status' => 'ok',
            'message' => 'Image has been added to gallery',
            'data' => null
        ]);
        $gallery1->refresh();
        $this->assertEquals(count($gallery1->images), 1);

        $response = $this->post('/api/v1/galleries/' . $gallery2->id, [
            
        ]);

        $response->assertStatus(401)->assertJsonFragment(['message' => 'Unauthorized']);


    }

    public function test_authorized_user_can_remove_an_image_from_a_gallery()
    {
        $user = User::factory()->create();
        $image = Image::factory()->create(['id' => $user->id]);
        $gallery1 = Gallery::factory()->create(['user_id' => $user->id, 'images' => json_encode([$image->id])]);
        $gallery2 = Gallery::factory()->create();
        $this->actingAs($user);
        $response = $this->delete('/api/v1/galleries/' . $gallery1->id . '/images', [
            'images' => json_encode([$image->id])
        ]);
        $response->assertStatus(200)->assertJsonFragment(['message' => 'Image has been successfully deleted']);
        $gallery1->refresh();
        $this->assertEquals(count($gallery1->images), false);

        $response = $this->delete('/api/v1/galleries/' . $gallery2->id . '/images', [
            'images' => json_encode([$image->id])
        ]);
        $response->assertStatus(401)->assertJsonFragment(['message' => 'Unauthorized']);
    }

    public function test_authorized_user_can_add_tags_to_a_gallery()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $gallery1= Gallery::factory()->create(['user_id'=> $user->id,'tags'=> []]);
        $gallery2= Gallery::factory()->create();
        $response= $this->post('/api/v1/galleries/'. $gallery1->id . '/tags',[
            'tags'=> json_encode([1])
        ]);
        $response->assertStatus(200)->assertJsonFragment(['message'=> 'Tags has been successfully added']);
        $gallery1->refresh();
        $this->assertEquals(count($gallery1->tags),1);
        
        $response= $this->post('/api/v1/galleries/'. $gallery2->id . '/tags',[
            'tags'=> serialize([1])
        ]);
        $response->assertStatus(401)->assertJsonFragment(['message'=> 'Unauthorized']);
    }

    public function test_authorized_user_can_remove_tags_from_a_gallery()
    {
        $user = User::factory()->create();  
        $this->actingAs($user);
        $gallery1= Gallery::factory()->create(['user_id'=> $user->id,'tags'=> [2]]);
        $gallery2= Gallery::factory()->create();
        $response= $this->delete('/api/v1/galleries/'.$gallery1->id . '/tags',['tags' => json_encode([2])]);
        $response->assertStatus(200)->assertJsonFragment(['message'=> 'Tags has been removed successfully']);
        $gallery1->refresh();
        $this->assertEmpty($gallery1->tags);

        $response= $this->delete('/api/v1/galleries/'.$gallery2->id . '/tags');
        $response->assertStatus(401)->assertJsonFragment(['message'=> 'Unauthorized']);
    }
}
