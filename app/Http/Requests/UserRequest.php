<?php

namespace App\Http\Requests;

use App\Traits\AuthorizesRoleOrPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    use AuthorizesRoleOrPermission;

    public function authorize(): bool
    {
        if ($this->method() === 'POST') {
            return $this->canAuthorizeRoleOrPermission('create users');
        }

        if (in_array($this->method(), ['PATCH', 'PUT'])) {
            return $this->canAuthorizeRoleOrPermission('update tickets');
        }

        return false;
    }

    public function rules(): array
    {
        if ($this->method() === 'POST') {
            $rule = [
                'email' => ['required_without:mobile', 'nullable', 'string', 'email', 'max:255', 'unique:users'],
                'mobile' => ['required_without:email', 'nullable', 'string', 'max:11', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];
        }

        if (in_array($this->method, ['PATCH', 'PUT'])) {
            $user = $this->route('user');
            $rule = [
                'email' => ['required_without:mobile', 'nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'mobile' => ['required_without:email', 'nullable', 'string', 'max:11', Rule::unique('users')->ignore($user->id)],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            ];
        }

        $common = [
            'name' => ['required', 'string', 'max:255'],
            'roles' => ['nullable', 'array'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ];

        return array_merge($common, $rule ?? []);
    }

    public function attributes()
    {
        return [
            'categories' => 'دسته‌بندی‌ها',
            'categories.*' => 'دسته‌بندی'
        ];
    }
}
