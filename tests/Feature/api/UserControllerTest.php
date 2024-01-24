<?php

namespace Tests\Feature\api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    // Tests index.

    public function databaseWithThreeUsers()
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


    /** @test */
    public function databaseWithoutUser()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(200);
        $users = $response->json();
        $this->assertCount(0, $users);
    }
    // Test store.

    /** @test */
    public function storeUser()
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
    public function notAllArgumentsAreSent()
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

    /** @test */
    public function getUserById()
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

    /** @test */
    public function retrieveUserThatDoesNotExistGet()
    {
        $response = $this->get('/api/users/1000');

        $response->assertStatus(404);

        $response->assertJson([
            'error' => 'Recurso no encontrado',
        ]);
    }

    // Tests update.

    /** @test */
    public function updateSuccessfully()
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

    /** @test */
    public function retrieveUserThatDoesNotExistPut()
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

    /** @test */
    public function deleteSuccessfully()
    {
        $user = User::factory()->create();

        $response = $this->json('DELETE', "/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Usuario eliminado',
            ]);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /** @test */
    public function retrieveUserThatDoesNotExistDelete()
    {
        $response = $this->json('DELETE', '/api/users/999');

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Recurso no encontrado',
            ]);
    }


    // public function testCreateUserThroughWebAndApi()
    // {
    //     $webResponse = $this->post('/users', [
    //         '_token' => csrf_token(),
    //         'name' => 'Diego a',
    //         'email' => 'prueba@example.com',
    //         'password' => 'contraseña',
    //     ]);
    //     $webResponse->assertStatus(302);

    //     $this->assertDatabaseHas('users', [
    //         'name' => 'Diego a',
    //         'email' => 'prueba@example.com',
    //     ]);

    //     $apiResponse = $this->json('POST', '/api/users', [
    //         'name' => 'Diego a',
    //         'email' => 'prueba@example.com',
    //         'password' => 'contraseña',
    //     ]);

    //     $apiResponse->assertStatus(201);

    //     $apiResponse->assertJson([
    //         'message' => 'Usuario creado.',
    //         'data' => [
    //             'name' => 'Diego a',
    //             'email' => 'prueba@example.com',
    //         ],
    //     ]);
    // }
}
