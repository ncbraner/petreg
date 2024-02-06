<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;
use App\Services\User\UserService;

class PetRegistration extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
        $this->artisan('db:seed', ['--class' => 'UserSeeder']);
        $this->artisan('db:seed', ['--class' => 'BreedsTableSeeder']);

        $this->withoutMiddleware();


        // Create a mock of the UserService
        $mockUserService = Mockery::mock(UserService::class);
        // Override the getUserId method to return a specific number
        $mockUserService->shouldReceive('getUserId')->andReturn(1); // replace 1 with the number you want to return

        // Bind the mock UserService into the service container
        $this->app->instance(UserService::class, $mockUserService);
        }

    public function testStoreWithValidData()
    {

        $data = [
            'authID' => 'auth0|65bfd16a2a18b1ef030a4e80', // Assuming 1 is a valid user_id and changing it to an integer
            'name' => 'bob',
            'type' => 'cat', // Changed to lowercase to match the enum definition
            'breed' => 22, // Assuming 22 is a valid breed_id and changing it to an integer
            'breedDetail' => 'Persian',
            'gender' => 'male',
            'mixDetail' => '',
        ];

        $response = $this->postJson('/api/pet-registrations', $data);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Pet registration successful']);
    }


    public function testStoreWithInvalidData()
    {


        $data = [
            'authID' => 'auth0|65bfd16a2a18b1ef030a4e80', // Assuming 1 is a valid user_id and changing it to an integer
            'name' => 'bob',
            'type' => 'cat', // Changed to lowercase to match the enum definition
            'breed' => 75, // Assuming 22 is a valid breed_id and changing it to an integer
            'breedDetail' => 'Persian',
            'gender' => 'male',
            'mixDetail' => '',
        ];

        $response = $this->postJson('/api/pet-registrations', $data);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'Pet registration failed to save']);
    }

    public function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
