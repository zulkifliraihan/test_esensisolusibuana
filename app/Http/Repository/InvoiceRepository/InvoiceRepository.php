<?php
namespace App\Http\Repository\InvoiceRepository;

use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceRepository implements InvoiceRepositoryInterface {
    private $invoice;
    private $invoiceItem;

    public function __construct(
        Invoice $invoice,
        InvoiceItem $invoiceItem
    )
    {
        $this->invoice = $invoice;
        $this->invoiceItem = $invoiceItem;
    }

    public function index(): ?object
    {

        $invoice = $this->invoice->with('item', 'customer')->get();

        return $invoice;
    }

    public function datatables($request): ?object
    {

        $invoice = $this->invoice->with('customer')->orderBy('created_at', 'DESC');

        if ($request->issued_date) {
            $invoice->whereDate('issued_date', $request->issued_date);
        }

        if ($request->subject) {
            $invoice->orWhere('subject', 'like', '%' . $request->subject . '%');
        }

        if ($request->total_items) {
            $invoice->orWhere('total_items',  $request->total_items);
        }

        if ($request->customer) {
            $invoice->orWhereHas('customer', function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->customer . '%');
            });
        }

        if ($request->due_date) {
            $invoice->orWhereDate('due_date',  $request->due_date);
        }

        if ($request->status) {
            $invoice->orWhere('status',  $request->status);
        }

        return $invoice;
    }

    public function create($data): object
    {
        $invoice = $this->invoice->create($data);

        return $invoice;
    }

    public function createItem($data): object
    {
        $invoice = $this->invoiceItem->create($data);

        return $invoice;
    }

    public function detail($id): ?object
    {
        $invoice = $this->invoice->with('item.item.type', 'customer')->find($id);

        return $invoice;
    }

    public function update($id, $data): object
    {
        $invoice = $this->invoice->find($id);

        $invoice->update($data);

        return $invoice;
    }

    public function deleteItem($invoiceId): ?int
    {
        $invoice = $this->invoice->find($invoiceId)->item()->delete();

        return $invoice;
    }

    public function delete($id): object
    {
        $invoice = $this->invoice->find($id);

        $invoice->item()->delete();
        $invoice->delete();

        return $invoice;
    }


}
