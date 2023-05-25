<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * A feature Get All.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->get('/api/customer');

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
            "name" => "Zulkifli Raihan",
            "address" => "Pondok Kelapa",
            "phone" => "6285691166309"
        ];

        $response = $this->post('/api/customer', $data);

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
        $customer = $this->testCreate();

        $response = $this->get('/api/customer/' . $customer['id']);

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
        $customer = $this->testCreate();

        $data = [
            "name" => "Raihan",
            "address" => "Pondok Kelapa",
            "phone" => "6285691166309"
        ];

        $response = $this->put('/api/customer/' . $customer['id'], $data);

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
        $customer = $this->testCreate();

        $response = $this->delete('/api/customer/' . $customer['id']);

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);
    }
}
