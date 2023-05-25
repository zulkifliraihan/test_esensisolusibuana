<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        try {
            $customerService = $this->customerService->index();

            return $this->success(
                $customerService['response'],
                $customerService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function create(CustomerRequest $customerRequest)
    {
        try {
            $customerService = $this->customerService->create($customerRequest->all());

            return $this->success(
                $customerService['response'],
                $customerService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function detail($id)
    {
        try {
            $customerService = $this->customerService->detail($id);

            if ($customerService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }
            return $this->success(
                $customerService['response'],
                $customerService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function update($id, CustomerRequest $customerRequest)
    {
        try {
            $customerService = $this->customerService->update($id, $customerRequest->all());

            if ($customerService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }

            return $this->success(
                $customerService['response'],
                $customerService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function delete($id)
    {
        try {
            $customerService = $this->customerService->delete($id);

            if ($customerService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }

            return $this->success(
                $customerService['response'],
                $customerService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

}
