<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function test_a_user_can_create_a_client()
    {
        $this->withoutExceptionHandling();

        $clientInfo = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),

        ];

        $this->post('/clients', $clientInfo)->assertRedirect('/clients');

        $this->assertDatabaseHas('clients', $clientInfo);

        $this->get('/clients')->assertSee($clientInfo['name']);
    }

    /** @test */
    public function a_user_can_view_a_client()
    {
        $this->withoutExceptionHandling();

        $client = Client::factory()->create();

        $this->get($client->path())
            ->assertSee($client->name)
            ->assertSee($client->email);
    }

    /** @test */
    public function test_a_client_requires_a_name()
    {
        $clientInfo = Client::factory()->raw(['name' => '']);

        $this->post('/clients', $clientInfo)->assertSessionHasErrors('name');
    }

    /** @test */
    public function test_a_client_requires_an_email()
    {
        $clientInfo = Client::factory()->raw(['email' => '']);

        $this->post('/clients', $clientInfo)->assertSessionHasErrors('email');
    }

    /** @test */
    public function test_a_client_requires_a_provider()
    {
        $clientInfo = Client::factory()->raw();

        $this->post('/clients', $clientInfo)->assertRedirect('login');
    }
}
