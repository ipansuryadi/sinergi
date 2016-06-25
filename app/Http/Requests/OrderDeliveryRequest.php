<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrderDeliveryRequest extends Request
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
            'ongkir_real'=>'required',
            'kurir'=>'required',
            'no_resi'=>'required',
            'delivery_date'=>'required'
        ];
    }
}
