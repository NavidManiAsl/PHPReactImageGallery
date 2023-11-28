<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GalleryControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * auth test DONE
     * user can create a gallery DONE
     * see all galleries DONE
     * see a gallery DONE
     * add image to a gallery 
     * remove an image from a gallery
     * delete a gallery
     */

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
        $gallery1 = Gallery::factory()->create(['user_id'=> $user->id]);
        $gallery2 = Gallery::factory()->create();
        $response = $this->delete('/api/v1/galleries/'. $gallery1->id);
        $response->assertStatus(200)->assertJson([
            'status' => 'ok',
            'message' => 'Gallery has been successfully deleted',
            'data' => null,
        ]);
        $this->assertNull(Gallery::find($user->id));

        $response = $this->delete('/api/v1/galleries/'. $gallery2->id);
        $response->assertStatus(401)->assertJsonFragment(['message'=> 'Unauthorized']);

    }
}
