<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResearchProjectRequest extends FormRequest
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
            'approval_ref'       => 'required|regex:/(^[A-Za-z0-9 \/\-_]+$)+/|max:200',
				
            'title'              => 'required|regex:/(^[A-Za-z0-9., -_]+$)+/|max:200',
            
            'start_date'         => 'required|date|date_format:Y-m-d',
            'end_date'           => 'required|date|date_format:Y-m-d|after:start_date',
            'approval_date'      => 'required|date|date_format:Y-m-d',
            
            'total_budget'       => 'nullable|numeric|between:0,999999999.99',
            'equip_budget'       => 'nullable|numeric|between:0,999999999.99',
            'consumable_budget'  => 'nullable|numeric|between:0,999999999.99',
            'contingency_budget' => 'nullable|numeric|between:0,999999999.99',
            
            'spcomments'         => 'nullable|regex:/(^[A-Za-z0-9 -_.,]+$)+/',
            'appletterfile'      => 'nullable|mimes:pdf|max:4096',
            'resprojfile'        => 'nullable|mimes:pdf|max:6096',
        ];
    }


    public function messages()
    {
        return [
            'approval_ref.required'  => 'Official Approval Reference Required',
            'title.required'         => 'Title is required, only Alpha, Numeric Characters',
            'start_date.required'    => 'Start Date is required',
            'end_date'               => 'End Date is required',
            'approval_date.required' => 'Approval Date is Required',
            'spcomments'             => 'Comments only Alpha, Numeric Characters',
            'appletterfile'          => 'Approval Letter file must be pdf below 4MB size',
            'resprojfile'            => 'Project File must be pdf below 4MB size',
        ];
    }


}
