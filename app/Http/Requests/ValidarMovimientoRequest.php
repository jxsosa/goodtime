<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarMovimientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user_id==auth()->user()->id) {
            return true;
        } else {
            return false;
        }
                
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules =[
            // 'bs' => 'required',
            // 'tasa' => 'required',
            'cliente_id' => 'required',
            'cuenta_id' => 'required',
            'cambio_id' => 'required',
        ];

        return $rules;
    }
}
