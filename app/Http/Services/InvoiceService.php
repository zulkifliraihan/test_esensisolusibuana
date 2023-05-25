<?php
namespace App\Http\Services;

use App\Http\Repository\CustomerRepository\CustomerRepositoryInterface;
use App\Http\Repository\InvoiceRepository\InvoiceRepositoryInterface;
use App\Http\Repository\ItemRepository\ItemRepositoryInterface;
use App\Models\Invoice;
use Carbon\Carbon;
use Error;
use Yajra\DataTables\DataTables;

class InvoiceService {
    private $invoiceRepostoryInterface;
    private $itemRepositoryInterface;
    private $customerRepositoryInterface;

    public function __construct(
        InvoiceRepositoryInterface $invoiceRepostoryInterface,
        ItemRepositoryInterface $itemRepositoryInterface,
        CustomerRepositoryInterface $customerRepositoryInterface
    )
    {
        $this->invoiceRepostoryInterface = $invoiceRepostoryInterface;
        $this->itemRepositoryInterface = $itemRepositoryInterface;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function index(): array
    {

        $invoice = $this->invoiceRepostoryInterface->index();

        $return = [
            'status' => 'success',
            'response' => 'get',
            'data' => $invoice
        ];

        return $return;
    }

    public function datatables($request)
    {
        if ($request->issued_date) {
            Carbon::setLocale('en');
            $request->issued_date = Carbon::createFromFormat('d/m/Y', $request->issued_date)->format('Y-m-d');
        }

        if ($request->due_date) {
            Carbon::setLocale('en');
            $request->due_date = Carbon::createFromFormat('d/m/Y', $request->due_date)->format('Y-m-d');
        }
        $invoice = $this->invoiceRepostoryInterface->datatables($request);

        return DataTables::of($invoice)
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create($data): array
    {
        $return = [];

        $validationData = $this->validationData($data);
        $return = $validationData;

        if (array_key_exists("status", $return)) {
            if ($return['status'] === 'error') {
                return $return;
            }
        }

        Carbon::setLocale('en');
        $issuedDate = Carbon::createFromFormat('d/m/Y', $data['issued_date'])->format('Y-m-d');
        $dueDate = Carbon::createFromFormat('d/m/Y', $data['due_date'])->format('Y-m-d');

        $dataInvoice = [
            'customer_id' => $data['customer_id'],
            'subject' => $data['subject'],
            'issued_date' => $issuedDate,
            'due_date' => $dueDate,
            'total_items' => $data['total_items'],
            'tax_rate' => $data['tax_rate'],
            'tax_total' => $data['tax_total'],
            'grand_total' => $data['grand_total'],
            'sub_total' => $data['sub_total'],
            'status' => 'unpaid'
        ];

        $invoice = $this->invoiceRepostoryInterface->create($dataInvoice);

        $dataInvoiceItem = [];
        foreach ($data['items'] as $key => $value) {
            $dataInvoiceItem = [
                'invoice_id' => $invoice->id,
                'item_id' => $value['item_id'],
                'qty' => $value['qty'],
                'total_price' => $value['total_price'],
            ];

            $invoiceItem = $this->invoiceRepostoryInterface->createItem($dataInvoiceItem);
        };


        $return = [
            'status' => 'success',
            'response' => 'created',
            'data' => $invoice
        ];

        return $return;


    }

    public function detail($id): array
    {
        $invoice = $this->invoiceRepostoryInterface->detail($id);

        if (!$invoice) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {
            $return = [
                'status' => 'success',
                'response' => 'get',
                'data' => $invoice
            ];
        }

        return $return;
    }

    public function update($id, $data): array
    {
        $return = [];

        $invoiceById = $this->invoiceRepostoryInterface->detail($id);

        if (!$invoiceById) {
            $return = [
                'status' => 'failed'
            ];

            return $return;
        }

        $validationData = $this->validationData($data);
        $return = $validationData;

        if (array_key_exists("status", $return)) {
            if ($return['status'] === 'error') {
                return $return;
            }
        }

        Carbon::setLocale('en');

        if (array_key_exists('issued_date', $data)) {
            $issuedDate = Carbon::createFromFormat('d/m/Y', $data['issued_date'])->format('Y-m-d');
            $data['issued_date'] = $issuedDate;
        }

        if (array_key_exists('due_date', $data)) {
            $dueDate = Carbon::createFromFormat('d/m/Y', $data['due_date'])->format('Y-m-d');
            $data['due_date'] = $dueDate;
        }
        if (array_key_exists('items', $data)) {
            $dataInvoiceItem = $data['items'];
            unset($data['items']);

            $deleteInvoiceItem = $this->invoiceRepostoryInterface->deleteItem($id);

            $dataInvoiceItem = [];
            foreach ($dataInvoiceItem as $key => $value) {
                $dataInvoiceItem = [
                    'invoice_id' => $id,
                    'item_id' => $value['item_id'],
                    'qty' => $value['qty'],
                    'total_price' => $value['total_price'],
                ];

                $invoiceItem = $this->invoiceRepostoryInterface->createItem($dataInvoiceItem);
            };
        }

        $dataInvoice = $data;

        $invoice = $this->invoiceRepostoryInterface->update($id, $dataInvoice);

        $return = [
            'status' => 'success',
            'response' => 'updated',
            'data' => $invoice
        ];


        return $return;
    }

    public function delete($id): array
    {

        $invoiceById = $this->invoiceRepostoryInterface->detail($id);

        if (!$invoiceById) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {

            $invoice = $this->invoiceRepostoryInterface->delete($id);

            $return = [
                'status' => 'success',
                'response' => 'deleted',
                'data' => $invoice
            ];
        }

        return $return;
    }

    public function setPaidStatus($id)
    {
        $invoiceById = $this->invoiceRepostoryInterface->detail($id);

        if (!$invoiceById) {
            $return = [
                'status' => 'failed'
            ];
        }
        else {

            $dataInvoice = [
                'status' => 'paid'
            ];

            $invoice = $this->invoiceRepostoryInterface->update($id, $dataInvoice);

            $return = [
                'status' => 'success',
                'response' => 'deleted',
                'data' => $invoice
            ];
        }

        return $return;

    }

    public function download($id)
    {
        $invoice = $this->invoiceRepostoryInterface->detail($id);

        if (!$invoice) {
            $return = [
                'status' => 'failed'
            ];
        }

        return $invoice;
    }

    private function validationData($data) {
        $return = [];
        if (array_key_exists('customer_id', $data)) {
            $checkCustomer = $this->customerRepositoryInterface->detail($data['customer_id']);

            if (!$checkCustomer) {
                $return = [
                    'status' => 'error',
                    'message' => "Customer ID not found",
                ];
            }
        }

        if (array_key_exists('items', $data) && array_key_exists('sub_total', $data)) {
            $subtotal = 0;
            foreach ($data['items'] as $key => $value) {
                $checkItem = $this->itemRepositoryInterface->detail($value['item_id']);
                if (!$checkItem) {
                    $return = [
                        'status' => 'error',
                        'message' => "Item ID not found",
                    ];

                    break;
                }
                else {
                    $totalPrice = $value['qty'] * $checkItem->unit_price;

                    if ($value['total_price'] !== $totalPrice) {
                        $return = [
                            'status' => 'error',
                            'message' => "Total Price in Items[${key}] is Wrong! Please Calculate Again!",
                        ];

                        break;
                    }

                    $subtotal += $totalPrice;
                }

            }

            if ($subtotal !== $data['sub_total']) {
                $return = [
                    'status' => 'error',
                    'message' => "Subtotal is Wrong! Please Calculate Again!",
                ];
            }
        }

        if (array_key_exists('tax_rate', $data)) {
            $taxTotal = $subtotal * ($data['tax_rate'] / 100);

            if ($taxTotal !== $data['tax_total']) {
                $return = [
                    'status' => 'error',
                    'message' => "Tax Total is Wrong! Please Calculate Again!",
                ];
            }
        }


        if (array_key_exists('grand_total', $data)) {
            $grandTotal = $taxTotal + $subtotal;

            if ($grandTotal !== $data['grand_total']) {
                $return = [
                    'status' => 'error',
                    'message' => "Grand Total is Wrong! Please Calculate Again!",
                ];
            }
        }

        if (array_key_exists('total_items', $data)) {
            $totalItems = count($data['items']);

            if ($totalItems !== $data['total_items']) {
                $return = [
                    'status' => 'error',
                    'message' => "Total Items is Wrong! Please Calculate Again!",
                ];
            }
        }

        return $return;


    }

}
