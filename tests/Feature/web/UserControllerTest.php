<?php

namespace Tests\Feature\web;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;


    public function testCreateUserWeb()
    {
        $response = $this->post('/users', [
            '_token' => csrf_token(),
            'name' => 'Diego a',
            'email' => 'prueba@example.com',
            'password' => 'contraseña',
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => 'Diego a',
            'email' => 'prueba@example.com',
        ]);
    }

    public function testCreateUserWebWithoutArgs()
    {
        $response = $this->post('/users', [
            '_token' => csrf_token(),
            'email' => 'prueba@example.com',
            'password' => 'contraseña',
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors('name');

        $response = $this->post('/users', [
            '_token' => csrf_token(),
            'name' => 'Diego a',
            'password' => 'contraseña',
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors('email');

        $response = $this->post('/users', [
            '_token' => csrf_token(),
            'email' => 'prueba@example.com',
            'name' => 'Diego a',
        ]);
        $response->assertStatus(302)
            ->assertSessionHasErrors('password');
    }

    public function testDeleteUserWeb()
    {
        $user = User::factory()->create();
        $response = $this->delete("/users/{$user->id}");
        $response->assertStatus(302);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function testShowUser()
    {
        $user = User::factory()->create();
        $response = $this->get("/users/" . $user->id);
        $response->assertStatus(200);
        $response->assertViewIs('user.show');
        $response->assertViewHas('user', $user);
    }
    public function testIndexUsers()
    {
        User::factory()->create();
        $response = $this->get("/users/");
        $response->assertStatus(200);
        $response->assertViewIs('user.index');
    }
    public function testEditUsers()
    {
        $user = User::factory()->create();
        $response = $this->get("/users/" . $user->id . "/edit");
        $response->assertStatus(200);
        $response->assertViewIs('user.edit');
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $updatedUserData = [
            'name' => 'new Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->put("/users/{$user->id}", $updatedUserData);

        $response->assertStatus(302);
        $response->assertRedirect('/users');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'new Name',
            'email' => 'updated@example.com',
        ]);
    }
}