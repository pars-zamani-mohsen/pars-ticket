<?php

namespace App\Services;

use Kavenegar\KavenegarApi;

class CustomKavenegarApi extends KavenegarApi
{
    const APIPATH = '%s://iran.api.kavenegar.com/v1/%s/%s/%s.json/';

    public function VerifyLookupV2($receptor, $template, $type, $token, $token2, $token3, $token10)
    {
        $path = $this->get_path('lookup', 'verify');
        $params = [
            'template' => $template,
            'receptor' => $receptor,
            'token' => $token,
            'token2' => $token2,
            'token3' => $token3,
            'token10' => $token10,
            'type' => $type,
        ];

        return $this->execute($path, $params);
    }

    public function VerifyLookupV2Simple(string $sender, string $receptor, string $message, $date = null, $type = null, $localid = null)
    {
        return $this->Send($sender, $receptor, $message, $date, $type, $localid);
    }

    public function VerifyLookupV2ArraySimple(array $sender, array $receptor, array $message, $date = null, $type = null, $localid = null)
    {
        return $this->SendArray($sender, $receptor, $message, $date, $type, $localid);
    }
}
