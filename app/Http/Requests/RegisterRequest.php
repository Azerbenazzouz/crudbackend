<?php
namespace App\Http\Requests;

class RegisterRequest extends BaseRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'birthday' => 'required|date',
            'password' => 'required|string',
        ];
    }

}

