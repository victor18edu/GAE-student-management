<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        Student::factory()->count(5)->create();

        $response = $this->get('/api/students');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'ra',
                    'cpf',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    public function testShow()
    {
        $student = Student::factory()->create();

        $response = $this->get('/api/students/'.$student->id);

        $response->assertStatus(200)
            ->assertJson($student->toArray());
    }

    public function testStore()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'ra' => '12345',
            'cpf' => '12345678901',
        ];

        $response = $this->post('/api/students', $payload);

        $response->assertStatus(201)
            ->assertJson($payload);

        $this->assertDatabaseHas('students', $payload);
    }

    public function testUpdate()
    {
        $student = Student::factory()->create();

        $payload = [
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'ra' => '54321',
            'cpf' => '98765432109',
        ];

        $response = $this->put('/api/students/'.$student->id, $payload);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $student = Student::factory()->create();

        $response = $this->delete('/api/students/'.$student->id);

        $response->assertStatus(200);
    }
}
