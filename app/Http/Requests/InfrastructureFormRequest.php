<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfrastructureFormRequest extends FormRequest
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
            'name'      => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/|max:200',
            'nickname'  => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'desc'      => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'dateacqrd' => 'required|date|date_format:Y-m-d',
            'make'      => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'model'     => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'vendor'    => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'phone'     => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'email'     => 'required|email',
            'building'  => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'floor'     => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'room'      => 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'amc'       => 'nullable|regex:/(^[A-Za-z0-9 -_]+$)+/',
            'amc_start' => 'nullable|date|date_format:Y-m-d',
            'amc_end'   => 'nullable|date|date_format:Y-m-d|after:amcstart',
            'supervisor'=> 'required|regex:/(^[A-Za-z0-9 -_]+$)+/',
        ];
    }
}
