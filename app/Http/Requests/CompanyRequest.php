<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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

            'company.name' => 'required|regex:/^[a-zA-Zà-ùÀ-Ù\s]+$/|min:3|max:50',
            'company.VAT' => 'required|regex:/^[0-9]+$/|max:11|min:11',
            'company.type_id' => 'nullable|exists:types,id',
            'company.address' => 'nullable|string|max:255',
            'company.description' => 'nullable|string',
            'company.logo' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'company.name.required' => 'Il nome dell\'azienda è obbligatorio.',
            'company.name.max' => 'Il nome non deve superare i :max caratteri',
            'company.name.min' => 'il nome non può essere inferiore a :min caratteri',
            'company.name.regex' => 'Il nome non accetta numeri',
            'company.VAT.regex' => 'La partita IVA deve contenere solo numeri',
            'company.VAT.required' => 'La partita IVA è obbligatoria.',
            'company.VAT.max' => 'La partita IVA può contenere massimo :max numeri',
            'company.VAT.min' => 'La partita IVA non può avere meno di :min numeri',
            'company.type.exists' =>'Il settore deve contenere un elemento valido',
            'company.address.max' => 'L\'indirizzo non deve superare :max caratteri'
            // 'company.logo.image' => 'L\'immagine non è valida',
            // 'company.logo.mimes' => 'L\'immagine può essere solo in formato .jpg, .png o .jpeg '
        ];
    }
}
