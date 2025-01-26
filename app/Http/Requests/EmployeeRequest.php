<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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

            'employee.company_id' => 'required|exists:companies,id',
            'employee.name' => 'required|min:3|max:50|regex:/^[a-zA-Zà-ùÀ-Ù\s]+$/',
            'employee.lastname' => 'required|string|min:3|max:50|regex:/^[a-zA-Zà-ùÀ-Ù\s]+$/',
            'employee.phone_number' => 'nullable|string|regex:/^\+?[0-9\s-]+$/|max:20',
            'employee.email' => 'nullable|email|max:50|unique:employees,email',
        ];


    }

    public function messages(): array
    {
        return [
            'employee.company_id.required' => 'L\'ID della compagnia è obbligatorio.',
            'employee.company_id.exists' => 'La compagnia selezionata non esiste.',

            'employee.name.required' => 'Il nome è obbligatorio.',
            'employee.name.min' => 'Il nome deve contenere almeno :min caratteri.',
            'employee.name.max' => 'Il nome non deve superare :max caratteri.',
            'employee.name.regex' => 'Il nome non può contenere numeri o caratteri speciali.',

            'employee.lastname.required' => 'Il cognome è obbligatorio.',
            'employee.lastname.min' => 'Il cognome deve contenere almeno :min caratteri.',
            'employee.lastname.max' => 'Il cognome non deve superare :max caratteri.',
            'employee.lastname.regex' => 'Il cognome non può contenere numeri o caratteri speciali.',

            'employee.phone_number.regex' => 'Il numero di telefono deve contenere solo numeri, spazi, trattini o il prefisso internazionale (+).',
            'employee.phone_number.max' => 'Il numero di telefono non deve superare :max caratteri.',

            'employee.email.email' => 'Inserisci un indirizzo email valido.',
            'employee.email.max' => 'L\'email non deve superare :max caratteri.',
            'employee.email.unique' => 'L\'email inserita è già in uso.',
        ];
    }
}
