<?php
namespace App\Http\Services;

use App\Http\Repository\CustomerRepository\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerService {
    private $customerRepostoryInterface;

    public function __construct(CustomerRepositoryInterface $customerRepostoryInterface)
    {
        $this->customerRepostoryInterface = $customerRepostoryInterface;
    }

    public function index(): array
    {

        $customer = $this->customerRepostoryInterface->index();

        $return = [
            'status' => 'success',
            'response' => 'get',
            'data' => $customer
        ];

        return $return;
    }

    public function create($data): array
    {
        $return = [];

        $customer = $this->customerRepostoryInterface->create($data);

        $return = [
            'status' => 'success',
            'response' => 'created',
            'data' => $customer
        ];

        return $return;


    }

    public function detail($id): array
    {
        $customer = $this->customerRepostoryInterface->detail($id);

        if (!$customer) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {
            $return = [
                'status' => 'success',
                'response' => 'get',
                'data' => $customer
            ];
        }

        return $return;
    }

    public function update($id, $data): array
    {

        $customerById = $this->customerRepostoryInterface->detail($id);

        if (!$customerById) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {
            $customer = $this->customerRepostoryInterface->update($id, $data);

            $return = [
                'status' => 'success',
                'response' => 'updated',
                'data' => $customer
            ];
        }

        return $return;
    }

    public function delete($id): array
    {

        $customerById = $this->customerRepostoryInterface->detail($id);

        if (!$customerById) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {

            $customer = $this->customerRepostoryInterface->delete($id);

            $return = [
                'status' => 'success',
                'response' => 'deleted',
                'data' => $customer
            ];
        }

        return $return;
    }


}
