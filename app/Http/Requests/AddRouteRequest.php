<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRouteRequest extends FormRequest
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
            'node_one'=>'required|integer',
            'node_two'=>'required|integer',
            'route_number'=>'required|integer',
            'distance'=>'required'
        ];
    }
}
