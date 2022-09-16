<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();

       if($method =='PUT') {
        return [
            'first_name' => ['required'],
           'last_name'=> ['required'],
            'gender'=> ['required'],
            'date_of_birth'=> ['required'],
            'contact_number'=> ['required'],
           'email'=> ['required'],
        ];
    }
    else{
        return [
            'first_name' => ['sometimes', 'required'],
           'last_name'=> ['sometimes','required'],
            'gender'=> ['sometimes','required'],
            'date_of_birth'=> ['sometimes','required'],
            'contact_number'=> ['sometimes','required'],
           'email'=> ['sometimes','required'],
        ];
    }
    }
}
