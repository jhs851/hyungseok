<?php

namespace App\Http\Requests;

use App\Core\SupportFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UserRequest extends FormRequest
{
    use SupportFormRequest;

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
        if ($this->isUpdate()) {
            return [
                'name' => ['required', 'string', 'max:255'],
                'password' => ['nullable', 'sometimes', 'string', 'min:8', 'confirmed'],
            ];
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     */
    public function withValidator(Validator $validator) : void
    {
        $validator->after(function (Validator $validator) {
            if ($this->isUpdate()) {
                $this->getInputSource()->remove('email');

                if (! $this->input('password')) {
                    $this->getInputSource()->remove('password');
                }
            }
        });
    }
}
