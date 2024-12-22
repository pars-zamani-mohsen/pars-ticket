<?php

namespace App\Http\Requests;

use App\Traits\AuthorizesRoleOrPermission;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    use AuthorizesRoleOrPermission;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $common = [
            'message' => ['required', 'string'],
            'attachments.*' => ['nullable', 'file', 'mimes:'.config('pars-ticket.file.memes', 'max:10240')],
        ];

        return array_merge($common, ($rule ?? []));
    }
}
