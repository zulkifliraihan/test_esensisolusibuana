<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TypeTest extends TestCase
{
    /**
     * A feature Get All.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->get('/api/type');

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);
    }

    /**
     * A feature Create.
     *
     * @return void
     */
    public function testCreate()
    {
        $data = [
            'name' => 'Software',
        ];

        $response = $this->post('/api/type', $data);

        $response->assertStatus(201);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);

        // $dataRespons
        $dataCreate = $responseData['data'];

        return $dataCreate;
    }

    /**
     * A feature Detail.
     *
     * @return void
     */
    public function testDetail()
    {
        $type = $this->testCreate();

        $response = $this->get('/api/type/' . $type['id']);

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);
    }

    /**
     * A feature Update.
     *
     * @return void
     */
    public function testUpdate()
    {
        $type = $this->testCreate();

        $data = [
            'name' => 'Lunak',
        ];

        $response = $this->put('/api/type/' . $type['id'], $data);

        $response->assertStatus(201);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);
    }

    /**
     * A feature Delete.
     *
     * @return void
     */
    public function testDelete()
    {
        $type = $this->testCreate();

        $response = $this->delete('/api/type/' . $type['id']);

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);
    }
}
