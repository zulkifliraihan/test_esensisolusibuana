<?php
namespace App\Http\Services;

use App\Http\Repository\TypeRepository\TypeRepositoryInterface;
use App\Models\Type;

class TypeService {
    private $typeRepostoryInterface;

    public function __construct(TypeRepositoryInterface $typeRepostoryInterface)
    {
        $this->typeRepostoryInterface = $typeRepostoryInterface;
    }

    public function index(): array
    {

        $type = $this->typeRepostoryInterface->index();

        $return = [
            'status' => 'success',
            'response' => 'get',
            'data' => $type
        ];

        return $return;
    }

    public function create($data): array
    {
        $return = [];

        $type = $this->typeRepostoryInterface->create($data);

        $return = [
            'status' => 'success',
            'response' => 'created',
            'data' => $type
        ];

        return $return;


    }

    public function detail($id): array
    {
        $type = $this->typeRepostoryInterface->detail($id);

        if (!$type) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {
            $return = [
                'status' => 'success',
                'response' => 'get',
                'data' => $type
            ];
        }

        return $return;
    }

    public function update($id, $data): array
    {

        $typeById = $this->typeRepostoryInterface->detail($id);

        if (!$typeById) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {
            $type = $this->typeRepostoryInterface->update($id, $data);

            $return = [
                'status' => 'success',
                'response' => 'updated',
                'data' => $type
            ];
        }

        return $return;
    }

    public function delete($id): array
    {

        $typeById = $this->typeRepostoryInterface->detail($id);

        if (!$typeById) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {

            $type = $this->typeRepostoryInterface->delete($id);

            $return = [
                'status' => 'success',
                'response' => 'deleted',
                'data' => $type
            ];
        }

        return $return;
    }


}
