<?php

namespace App\Http\Requests\Cpf;

use App\Exceptions\MsgExeptions;
use App\Exceptions\ServiceException;
use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CpfStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'cpf' => 'required|cpf:filter|unique:cpfs',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */

    public function messages(): array
    {
        return [
            'cpf.required' => 'REQUIRED',
            'cpf.cpf' => 'INVALID',
            'cpf.unique' => 'EXISTS',
        ];
    }

    /**
     * @param Validator $validator
     * @throws ServiceException
     */
    protected function failedValidation(Validator $validator)
    {
        foreach ($validator->errors()->all() as $message) {
            throw new ServiceException(MsgExeptions::CPF[$message]['MSG'],MsgExeptions::CPF[$message]['TYPE'], 422);
        }
    }

}
