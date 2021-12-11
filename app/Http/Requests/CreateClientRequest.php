<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
        $email = $this->request->get("id");
        $rules =  [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'mobile' => ['required', 'numeric', 'digits_between:11,11'],
            'address' => ['string', 'max:1000'],
            'latitude' => 'required|between:-90,90',
            'longitude' => 'required|between:-180,180'
        ];
        return $rules;
    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
