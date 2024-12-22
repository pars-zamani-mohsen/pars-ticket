<?php

namespace App\Http\Requests;

use App\Traits\AuthorizesRoleOrPermission;
use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    use AuthorizesRoleOrPermission;

    public function authorize(): bool
    {
        if ($this->method() === 'POST') {
            return $this->canAuthorizeRoleOrPermission('create permissions');
        }

        if (in_array($this->method(), ['PATCH', 'PUT'])) {
            return $this->canAuthorizeRoleOrPermission('edit permissions');
        }

        return false;
    }

    public function rules(): array
    {
        if ($this->method() === 'POST') {
            $rule = [
                'name' => ['required', 'unique:permissions,name'],
            ];
        }

        if (in_array($this->method, ['PATCH', 'PUT'])) {
            $permission = $this->route('permission');
            $rule = [
                'name' => ['required', 'unique:permissions,name,' . $permission->id],
            ];
        }

        $common = [
            'description' => ['nullable', 'string']
        ];

        return array_merge($common, $rule ?? []);
    }
}
