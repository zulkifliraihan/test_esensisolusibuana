<?php

namespace App\Http\Requests;

use App\Traits\ReturnResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class InvoiceRequest extends FormRequest
{
    use ReturnResponser;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return [
                    'issued_date' => 'date_format:d/m/Y',
                    'subject' => 'string',
                    'total_items' => 'numeric|min:0.00',
                    'customer' => 'string',
                    'due_date' => 'date_format:d/m/Y',
                    'status' => 'string',
                ];
                break;
            case 'POST':
                return [
                    'customer_id' => 'required|integer',
                    'subject' => 'required|string',
                    'issued_date' => 'required|date_format:d/m/Y',
                    'due_date' => 'required|date_format:d/m/Y',
                    'total_items' => 'required|numeric|min:0.00',
                    'sub_total' => 'required|numeric|min:0.00',
                    'tax_rate' => 'required|integer',
                    'tax_total' => 'required|numeric|min:0.00',
                    'grand_total' => 'required|numeric|min:0.00',
                    'items' => 'required|array',
                ];
                break;
            case 'PUT':
                    return [
                        'customer_id' => 'sometimes|integer',
                        'subject' => 'sometimes|string',
                        'issued_date' => 'sometimes|date_format:d/m/Y',
                        'due_date' => 'sometimes|date_format:d/m/Y',
                        'total_items' => 'sometimes|numeric|min:0.00',
                        'sub_total' => 'sometimes|numeric|min:0.00',
                        'tax_rate' => 'sometimes|integer',
                        'tax_total' => 'sometimes|numeric|min:0.00',
                        'grand_total' => 'sometimes|numeric|min:0.00',
                        'items' => 'sometimes|array',
                ];
                break;
            default:
                break;
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorvalidator($validator->errors()->first()));
    }
}
