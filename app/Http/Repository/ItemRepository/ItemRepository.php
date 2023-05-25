<?php
namespace App\Http\Repository\ItemRepository;

use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface {
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function index(): ?object
    {

        $item = $this->item->all();

        return $item;
    }

    public function create($data): object
    {
        $return = [];

        $item = $this->item->firstOrCreate($data);


        return $item;


    }

    public function detail($id): ?object
    {
        $item = $this->item->find($id);

        return $item;
    }


    public function update($id, $data): object
    {
        $item = $this->item->find($id);

        $item->update($data);

        return $item;
    }

    public function delete($id): object
    {
        $item = $this->item->find($id);

        $item->delete();

        return $item;
    }


}
