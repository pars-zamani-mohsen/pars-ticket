<?php

namespace App\Http\Requests;

use App\Traits\AuthorizesRoleOrPermission;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class MessageRequest extends FormRequest
{
    use AuthorizesRoleOrPermission;

    protected $rateLimiter;

    public function __construct(RateLimiter $rateLimiter)
    {
        $this->rateLimiter = $rateLimiter;
    }

    public function authorize(): bool
    {
        $key = 'ticket_submission_' . $this->user()->id;

        if ($this->rateLimiter->tooManyAttempts($key, 5)) { // 1 attempt allowed
            $seconds = $this->rateLimiter->availableIn($key);
            abort(Response::HTTP_TOO_MANY_REQUESTS,
                __('ticket.too_many_attemps_message', ['seconds' => $seconds]));
        }

        $this->rateLimiter->hit($key, 30); // 60 seconds decay
        return true;
    }

    public function rules(): array
    {
        $common = [
            'message' => ['required', 'string',
                function($attribute, $value, $fail) {
                    $stripped = strip_tags($value);
                    if (trim($stripped) === '') {
                        $fail(__('ticket.message_can_not_empty'));
                    }
                }
            ],
            'attachments.*' => ['nullable', 'file', 'mimes:'.config('pars-ticket.file.memes', 'max:10240')],
        ];

        return array_merge($common, ($rule ?? []));
    }
}
