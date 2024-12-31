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
            if (! $this->canAuthorizeRoleOrPermission(['show tickets all'])) {
                $ticket = $this->route('ticket');

                if ($ticket->user_id === auth()->id()) {
                    return true;
                }

                if ($this->canAuthorizeRoleOrPermission(['show tickets all-in-category'])) {
                    $userCategoryIds = auth()->user()->categories->pluck('id')->toArray();
                    $ticketCategoryIds = $ticket->categories->pluck('id')->toArray();

                    return ! empty(array_intersect($userCategoryIds, $ticketCategoryIds));
                }

                return false;
            }

            return true;
        }

        return true;
    }

    public function rules(): array
    {
        if ($this->method() === 'POST') {
            $rule = [
                'title' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string',
                    function($attribute, $value, $fail) {
                        $stripped = strip_tags($value);
                        if (trim($stripped) === '') {
                            $fail(__('ticket.message_can_not_empty'));
                        }
                    }
                ],
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
                'categories' => ['nullable', 'array'],
                'categories.*' => ['exists:categories,id'],
            ];
        }

        $common = [];

        return array_merge($common, $rule ?? []);
    }
}
