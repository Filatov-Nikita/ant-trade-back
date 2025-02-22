<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperationCashRequest extends FormRequest
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
            'sum' => 'required|numeric',
            'company_id' => 'required|exists:companies,id',
            'comment' => 'nullable|max:255',
            'type' => 'in:purchase,supply',
            'files' => 'nullable|array',
            'files.*' => 'integer|exists:files,id',
        ];
    }
}
