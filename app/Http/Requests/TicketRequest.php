<?php

namespace App\Http\Requests;

use App\Enums\TicketPriorityEnum;
use App\Traits\AuthorizesRoleOrPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketRequest extends FormRequest
{
    use AuthorizesRoleOrPermission;

    public function authorize(): bool
    {
        if (in_array($this->method(), ['PATCH', 'PUT'])) {
            if (! $this->canAuthorizeRoleOrPermission(['super-admin', 'admin', 'operator'])) {
                $ticket = $this->route('ticket');
                if ($ticket->user_id !== auth()->id()) {
                    return false;
                }
            }
        }

        return true;
    }

    public function rules(): array
    {
        if ($this->method() === 'POST') {
            $rule = [
                'title' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string'],
                'user_id' => ['nullable', 'int', 'exists:users,id'],
                'priority' => ['required', Rule::in(TicketPriorityEnum::getArray())],
                'categories' => ['nullable', 'array'],
                'categories.*' => ['exists:categories,id'],
                'labels' => ['nullable', 'array'],
                'labels.*' => ['exists:labels,id']
            ];
        }

        if (in_array($this->method, ['PATCH', 'PUT'])) {
            $rule = [
                'is_resolved' => ['sometimes', 'boolean'],
                'is_locked' => ['sometimes', 'boolean'],
                'assigned_to' => ['sometimes', 'nullable', 'exists:users,id'],
                'status' => ['sometimes', 'in:open,closed'],
            ];
        }

        $common = [];

        return array_merge($common, $rule ?? []);
    }
}
