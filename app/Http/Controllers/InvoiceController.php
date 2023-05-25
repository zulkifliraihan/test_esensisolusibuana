<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Services\InvoiceService;
use PDF;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        try {
            $invoiceService = $this->invoiceService->index();

            return $this->success(
                $invoiceService['response'],
                $invoiceService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function datatables(InvoiceRequest $request)
    {
        try {
            $invoiceService = $this->invoiceService->datatables($request);

            return $invoiceService;

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function create(InvoiceRequest $invoiceRequest)
    {
        try {
            $invoiceService = $this->invoiceService->create($invoiceRequest->all());

            if ($invoiceService['status'] === 'error') {
                return $this->errorServer($invoiceService['message']);
            }

            return $this->success(
                $invoiceService['response'],
                $invoiceService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function detail($id)
    {
        try {
            $invoiceService = $this->invoiceService->detail($id);

            if ($invoiceService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }
            return $this->success(
                $invoiceService['response'],
                $invoiceService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function update($id, InvoiceRequest $invoiceRequest)
    {
        try {
            $invoiceService = $this->invoiceService->update($id, $invoiceRequest->all());

            if ($invoiceService['status'] === 'failed') {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }

            if ($invoiceService['status'] === 'error') {
                return $this->errorServer($invoiceService['message']);
            }

            return $this->success(
                $invoiceService['response'],
                $invoiceService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function delete($id)
    {
        try {
            $invoiceService = $this->invoiceService->delete($id);

            if ($invoiceService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }

            return $this->success(
                $invoiceService['response'],
                $invoiceService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function setPaidStatus($id)
    {
        try {
            $invoiceService = $this->invoiceService->setPaidStatus($id);

            if ($invoiceService['status'] == "failed") {
                return $this->errorvalidator(null, "ID Not Found", 400);
            }

            return $this->success(
                $invoiceService['response'],
                $invoiceService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());

        }
    }

    public function download($id)
    {
        $invoiceService = $this->invoiceService->download($id);

        $data = [
            'invoice' => $invoiceService
        ];

        return view('invoice', $data);
    }

}
