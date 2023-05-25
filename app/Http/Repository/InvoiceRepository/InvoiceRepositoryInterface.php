<?php
namespace App\Http\Repository\InvoiceRepository;

interface InvoiceRepositoryInterface {
    public function index(): ?object;
    public function datatables($request): ?object;
    public function create($data): object;
    public function createItem($data): object;
    public function detail($id): ?object;
    public function update($id, $data): object;
    public function deleteItem($invoiceId): ?int;
    public function delete($id): object;
}
