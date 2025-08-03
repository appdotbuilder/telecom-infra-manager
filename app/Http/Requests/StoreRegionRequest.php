<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegionRequest extends FormRequest
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
        $stage = $this->input('stage', 'data');
        
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:regions,code',
            'description' => 'nullable|string',
            'stage' => 'required|in:data,design,rab,permits,completed',
        ];

        // Stage-specific validation
        switch ($stage) {
            case 'data':
                $rules['boundaries'] = 'nullable|array';
                break;
            case 'design':
                $rules['design_data'] = 'nullable|array';
                $rules['design_data.plan_file'] = 'nullable|string';
                $rules['design_data.technical_specs'] = 'nullable|string';
                break;
            case 'rab':
                $rules['rab_data'] = 'nullable|array';
                $rules['rab_data.budget_estimate'] = 'nullable|numeric|min:0';
                $rules['rab_data.cost_breakdown'] = 'nullable|array';
                break;
            case 'permits':
                $rules['permits_data'] = 'nullable|array';
                $rules['permits_data.permits_required'] = 'nullable|array';
                $rules['permits_data.applications_submitted'] = 'nullable|array';
                break;
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Region name is required.',
            'code.required' => 'Region code is required.',
            'code.unique' => 'This region code is already in use.',
            'stage.required' => 'Stage is required.',
            'stage.in' => 'Stage must be data, design, rab, permits, or completed.',
        ];
    }
}