<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddScheduleRequest extends FormRequest
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
            'route_id'=>'required|integer',
            'direction'=>'required',
            'start_timestamp'=>'required',
            'end_timestamp'=>'required',
        ];
    }
}
