<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'orden_id' => 'required',
			'metodopagos_id' => 'required',
			'estado_id' => 'required',
			'nombre' => 'required|string',
			'monto_pago' => 'required',
			'fecha_pago' => 'required',
        ];
    }
}
