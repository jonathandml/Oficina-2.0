<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormValidation extends FormRequest
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
            'client' => 'required',
            'estimatedValue' => ['required','numeric'],
            'description' => ['required']
        ];
    }

    public function messages(){
        return [
            'client.required'=> 'O campo Cliente é obrigatório',
            'estimatedValue.required'=> 'O campo Valor é obrigatório',
            'estimatedValue.numeric'=> 'O campo Valor deve ser um número',
            'description.required'=> 'O campo Descrição é obrigatório'  
        ];
    }
}
