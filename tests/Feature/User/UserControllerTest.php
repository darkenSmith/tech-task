<?php
namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_successfully()
    {
        Storage::fake('public');

        $response = $this->postJson('/api/users', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1234567890',
            'country' => 'United States',
            'gender' => 'male',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'profile_picture' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'surname',
                    'email',
                    'phone',
                    'country',
                    'gender',
                    'profile_picture',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_get_user_successfully()
    {
        $user = User::factory()->create([
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'John',
                    'surname' => 'Doe',
                    'email' => 'john.doe@example.com',
                ],
            ]);
    }

    public function test_update_user_successfully()
    {
        $user = User::factory()->create([
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'alex',
            'surname' => $user->surname,
            'email' => $user->email,
            'phone' => $user->phone,
            'country' => $user->country,
            'gender' => $user->gender,
            'profile_picture' => $user->profile_picture,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'alex',
                    'surname' => 'Doe',
                    'email' => 'john.doe@example.com',
                ],
            ]);
    }

    public function test_delete_user_successfully(){
        $user = User::factory()->create([
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);

        $response = $this->deleteJson("/api/users/{$user->id}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);
    }
}
