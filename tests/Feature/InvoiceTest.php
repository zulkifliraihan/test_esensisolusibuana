<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /**
     * A feature Get All.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->get('/api/invoice');

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);
    }

    /**
     * A feature Datatables.
     *
     * @return void
     */
    public function testDatatables()
    {
        $response = $this->get('/api/invoice/datatables');

        $response->assertStatus(200);
    }

    /**
     * A feature Create.
     *
     * @return void
     */
    public function testCreate()
    {
        $data = [
            "customer_id" => 5,
            "subject" => "Spring Marketing Campaign",
            "issued_date" => "20/05/2017",
            "due_date" => "25/05/2017",
            "total_items" => 3,
            "sub_total" => 28510.00,
            "tax_rate" => 10,
            "tax_total" => 2851.00,
            "grand_total" => 31361.00,
            "items" => [
                [
                    "item_id" => 1,
                    "qty" => 41.00,
                    "total_price" => 9430.00
                ],
                [
                    "item_id" => 2,
                    "qty" => 57.00,
                    "total_price" => 18810.00
                ],
                [
                    "item_id" => 3,
                    "qty" => 4.50,
                    "total_price" => 270.00
                ]
            ]
        ];

        $response = $this->post('/api/invoice', $data);

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
        $invoice = $this->testCreate();

        $response = $this->get('/api/invoice/' . $invoice['id']);

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
        $invoice = $this->testCreate();

        $data = [
            "customer_id" => 7,
            "subject" => "Lemon Influencer",
            "issued_date" => "20/05/2017",
            "due_date" => "25/05/2017",
            "total_items" => 3,
            "sub_total" => 28510.00,
            "tax_rate" => 10,
            "tax_total" => 2851.00,
            "grand_total" => 31361.00,
            "items" => [
                [
                    "item_id" => 1,
                    "qty" => 41.00,
                    "total_price" => 9430.00
                ],
                [
                    "item_id" => 2,
                    "qty" => 57.00,
                    "total_price" => 18810.00
                ],
                [
                    "item_id" => 3,
                    "qty" => 4.50,
                    "total_price" => 270.00
                ]
            ]
        ];

        $response = $this->put('/api/invoice/' . $invoice['id'], $data);

        $response->assertStatus(201);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);
    }

    /**
     * A feature Paid.
     *
     * @return void
     */
    public function testPaid()
    {
        $invoice = $this->testCreate();

        $response = $this->patch('/api/invoice/' . $invoice['id'] . '/set-paid');

        $response->assertStatus(200);
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
        $invoice = $this->testCreate();

        $response = $this->delete('/api/invoice/' . $invoice['id']);

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertArrayHasKey('response_code', $responseData);
        $this->assertArrayHasKey('response_status', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('data', $responseData);
    }

}
