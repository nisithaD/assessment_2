<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookScheduleRequest extends FormRequest
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
            'bus_seat_id'=>'required|integer',
            'bus_schedule_id'=>'required|integer',
            'status'=>'required|integer'
        ];
    }
}
