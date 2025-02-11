<?php
namespace App\Http\Requests;

class RegisterRequest extends BaseRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'birthday' => 'required|date',
            'password' => 'required|string',
        ];
    }

}

