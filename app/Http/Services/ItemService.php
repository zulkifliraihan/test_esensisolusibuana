<?php
namespace App\Http\Services;

use App\Http\Repository\ItemRepository\ItemRepositoryInterface;
use App\Models\Item;

class ItemService {
    private $itemRepostoryInterface;

    public function __construct(ItemRepositoryInterface $itemRepostoryInterface)
    {
        $this->itemRepostoryInterface = $itemRepostoryInterface;
    }

    public function index(): array
    {

        $item = $this->itemRepostoryInterface->index();

        $return = [
            'status' => 'success',
            'response' => 'get',
            'data' => $item
        ];

        return $return;
    }

    public function create($data): array
    {
        $return = [];

        $item = $this->itemRepostoryInterface->create($data);

        $return = [
            'status' => 'success',
            'response' => 'created',
            'data' => $item
        ];

        return $return;


    }

    public function detail($id): array
    {
        $item = $this->itemRepostoryInterface->detail($id);

        if (!$item) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {
            $return = [
                'status' => 'success',
                'response' => 'get',
                'data' => $item
            ];
        }

        return $return;
    }

    public function update($id, $data): array
    {

        $itemById = $this->itemRepostoryInterface->detail($id);

        if (!$itemById) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {
            $item = $this->itemRepostoryInterface->update($id, $data);

            $return = [
                'status' => 'success',
                'response' => 'updated',
                'data' => $item
            ];
        }

        return $return;
    }

    public function delete($id): array
    {

        $itemById = $this->itemRepostoryInterface->detail($id);

        if (!$itemById) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {

            $item = $this->itemRepostoryInterface->delete($id);

            $return = [
                'status' => 'success',
                'response' => 'deleted',
                'data' => $item
            ];
        }

        return $return;
    }


}
