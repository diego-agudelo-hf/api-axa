<?php

namespace Tests\Feature\api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function testDatabaseConnection()
    {
        $connection = config('database.default');
        if ($connection === env('DB_CONNECTION_TESTING') ? env('DB_CONNECTION_TESTING') : '') {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    // Tests index.
    public function testDatabaseWithThreeUsers()
    {
        User::factory()->count(3)->create();
        $response = $this->get('/api/users');
        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
        ]);
    }


    public function testDatabaseWithoutUser()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(200);
        $users = $response->json();
        $this->assertEmpty($users);
    }

    // Test store.
    public function testStoreUser()
    {
        $userData = [
            'name' => 'Diego A',
            'email' => 'diego@fakemail.com',
            'password' => '***********',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Usuario creado.',
                'data' => [
                    'name' => 'Diego A',
                    'email' => 'diego@fakemail.com',
                ],
            ]);
        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'id' => $response['data']['id'],
        ]);
    }

    /** @test */
    public function testNotAllArgumentsAreSent()
    {
        $response = $this->json('POST', '/api/users', []);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Error en la validación',
            ]);

        $userData = [
            'name' => 'Diego A',
            'password' => '***********',
        ];
        $response = $this->json('POST', '/api/users', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Error en la validación',
            ]);
    }

    // Tests show.

    public function testGetUserById()
    {
        $user = User::factory()->create();
        $response = $this->get("/api/users/{$user->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    public function testRetrieveUserThatDoesNotExistGet()
    {
        $response = $this->get('/api/users/1000');
        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'Recurso no encontrado',
        ]);
    }

    // Tests update.

    public function testUpdateSuccessfully()
    {
        $user = User::factory()->create();
        $newData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];
        $response = $this->json('PUT', "/api/users/{$user->id}", $newData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Usuario actualizado con éxito',
                'data' => [
                    'name' => $newData['name'],
                    'email' => $newData['email'],
                ],
            ]);

        $user->refresh();
        $this->assertEquals($newData['name'], $user->name);
        $this->assertEquals($newData['email'], $user->email);
    }

    public function testRetrieveUserThatDoesNotExistPut()
    {
        $newData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->json('PUT', '/api/users/999', $newData);

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Recurso no encontrado',
            ]);
    }

    // Test destroy.

    public function testDeleteSuccessfully()
    {
        $user = User::factory()->create();
        $response = $this->json('DELETE', "/api/users/{$user->id}");
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Usuario eliminado',
            ]);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function testRetrieveUserThatDoesNotExistDelete()
    {
        $response = $this->json('DELETE', '/api/users/999');

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Recurso no encontrado',
            ]);
    }
}