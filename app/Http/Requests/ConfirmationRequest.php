<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConfirmationRequest extends Request
{
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
        return [
            'order_id' => 'required',
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'bank_id' => 'required',
            'amount' => 'required|numeric',
        ];
    }
}
