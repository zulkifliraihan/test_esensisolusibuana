<?php
namespace App\Http\Repository\CustomerRepository;

use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface {
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index(): ?object
    {

        $customer = $this->customer->all();


        return $customer;
    }

    public function create($data): object
    {
        $return = [];

        $customer = $this->customer->firstOrCreate($data);

        return $customer;


    }

    public function detail($id): ?object
    {
        $customer = $this->customer->find($id);

        return $customer;
    }

    public function update($id, $data): object
    {
        $customer = $this->customer->find($id);

        $customer->update($data);

        return $customer;
    }

    public function delete($id): object
    {
        $customer = $this->customer->find($id);

        $customer->delete();
        
        return $customer;
    }


}
