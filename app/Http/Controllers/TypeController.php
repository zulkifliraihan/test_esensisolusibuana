<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequest;
use App\Http\Services\TypeService;
use Illuminate\Http\Request;

class TypeController extends Controller
{

    private $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    public function index()
    {
        try {
            $typeService = $this->typeService->index();

            return $this->success(
                $typeService['response'],
                $typeService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function create(TypeRequest $typeRequest)
    {
        try {
            $typeService = $this->typeService->create($typeRequest->all());

            return $this->success(
                $typeService['response'],
                $typeService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function detail($id)
    {
        try {
            $typeService = $this->typeService->detail($id);

            if ($typeService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }
            return $this->success(
                $typeService['response'],
                $typeService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function update($id, TypeRequest $typeRequest)
    {
        try {
            $typeService = $this->typeService->update($id, $typeRequest->all());

            if ($typeService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }

            return $this->success(
                $typeService['response'],
                $typeService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function delete($id)
    {
        try {
            $typeService = $this->typeService->delete($id);

            if ($typeService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }

            return $this->success(
                $typeService['response'],
                $typeService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

}
