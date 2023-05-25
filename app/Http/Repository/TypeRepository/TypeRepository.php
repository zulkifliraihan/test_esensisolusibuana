<?php
namespace App\Http\Repository\TypeRepository;

use App\Models\Type;

class TypeRepository implements TypeRepositoryInterface {
    private $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function index(): ?object
    {

        $type = $this->type->all();

        return $type;
    }

    public function create($data): object
    {

        $type = $this->type->firstOrCreate($data);

        return $type;

    }

    public function detail($id): ?object
    {
        $type = $this->type->find($id);

        return $type;
    }

    public function update($id, $data): object
    {
        $type = $this->type->find($id);

        $type->update($data);

        return $type;
    }

    public function delete($id): object
    {
        $type = $this->type->find($id);

        $type->delete();

        return $type;
    }


}
