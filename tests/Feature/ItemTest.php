<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemTest extends TestCase
{
    /**
     * A feature Get All.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->get('/api/item');

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
            "type_id" => 2,
            "name" => "Testing",
            "unit_price" => 2.20
        ];

        $response = $this->post('/api/item', $data);

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
        $item = $this->testCreate();

        $response = $this->get('/api/item/' . $item['id']);

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
        $item = $this->testCreate();

        $data = [
            "type_id" => 2,
            "name" => "Testing",
            "unit_price" => 3.20
        ];

        $response = $this->put('/api/item/' . $item['id'], $data);

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
        $item = $this->testCreate();

        $response = $this->delete('/api/item/' . $item['id']);

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);
    }
}
