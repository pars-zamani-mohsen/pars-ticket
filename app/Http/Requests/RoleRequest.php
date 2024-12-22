<?php

namespace App\Http\Requests;

use App\Traits\AuthorizesRoleOrPermission;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    use AuthorizesRoleOrPermission;

    public function authorize(): bool
    {
        if ($this->method() === 'POST') {
            return $this->canAuthorizeRoleOrPermission('create roles');
        }

        if (in_array($this->method(), ['PATCH', 'PUT'])) {
            return $this->canAuthorizeRoleOrPermission('edit roles');
        }

        return false;
    }

    public function rules(): array
    {
        if ($this->method() === 'POST') {
            $rule = [
                'name' => ['required', 'unique:roles,name'],
            ];
        }

        if (in_array($this->method, ['PATCH', 'PUT'])) {
            $role = $this->route('role');
            $rule = [
                'name' => ['required', 'unique:roles,name,' . $role->id],
            ];
        }

        $common = [
            'permissions' => ['required', 'array']
        ];

        return array_merge($common, $rule ?? []);
    }
}
