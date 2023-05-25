<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {
        try {
            $itemService = $this->itemService->index();

            return $this->success(
                $itemService['response'],
                $itemService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function create(ItemRequest $itemRequest)
    {
        try {
            $itemService = $this->itemService->create($itemRequest->all());

            return $this->success(
                $itemService['response'],
                $itemService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function detail($id)
    {
        try {
            $itemService = $this->itemService->detail($id);

            if ($itemService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }
            return $this->success(
                $itemService['response'],
                $itemService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function update($id, ItemRequest $itemRequest)
    {
        try {
            $itemService = $this->itemService->update($id, $itemRequest->all());

            if ($itemService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }

            return $this->success(
                $itemService['response'],
                $itemService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function delete($id)
    {
        try {
            $itemService = $this->itemService->delete($id);

            if ($itemService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }

            return $this->success(
                $itemService['response'],
                $itemService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

}
