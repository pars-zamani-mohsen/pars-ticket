<?php

namespace App\Services\Notifications;

use App\Contracts\SMSServiceInterface;
use App\Services\CustomKavenegarApi;
use Illuminate\Support\Facades\Log;

class KavenegarSMSService implements SMSServiceInterface
{
    private string $apiKey;
    private string $sender;

    public function __construct()
    {
        $this->apiKey = config('pars-ticket.sms_api_key.kavenegar-url');
        $this->sender = config('pars-ticket.sms_api_key.kavenegar-number');
    }

    public function send(string $mobile, string $message): bool
    {
        try {
            $api = new CustomKavenegarApi($this->apiKey);
            return $api->VerifyLookupV2Simple($this->sender, $mobile, $message);

        } catch (\Exception $e) {
            Log::error('SMS service error', [
                'mobile' => $mobile,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function sendBulk(array $mobiles, string $message): array
    {
        $results = [];
        foreach ($mobiles as $mobile) {
            $results[$mobile] = $this->send($mobile, $message);
        }
        return $results;
    }
}
