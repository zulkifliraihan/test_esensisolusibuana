<?php
namespace App\Http\Repository\CustomerRepository;

interface CustomerRepositoryInterface {
    public function index(): ?object;
    public function create($data): object;
    public function detail($id): ?object;
    public function update($id, $data): object;
    public function delete($id): object;
}
