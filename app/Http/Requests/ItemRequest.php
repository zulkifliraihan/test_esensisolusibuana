<?php

namespace App\Http\Requests;

use App\Traits\ReturnResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ItemRequest extends FormRequest
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
            case 'POST':
                return [
                    'type_id' => 'required|integer',
                    'name' => 'required|string',
                    'unit_price' => 'required|numeric|min:0.00',
                ];
                break;
                case 'PUT':
                    return [
                        'type_id' => 'sometimes|integer',
                        'name' => 'sometimes|string',
                        'unit_price' => 'sometimes|numeric|min:0.00',
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
