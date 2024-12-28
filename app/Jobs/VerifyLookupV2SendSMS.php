<?php

namespace App\Jobs;

use App\Services\CustomKavenegarApi;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyLookupV2SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $receptor;
    protected $template;
    protected $type;
    protected $token;
    protected $token2;
    protected $token3;
    protected $token10;

    /**
     * VerifyLookupV2SendSMS constructor.
     * @param $receptor
     * @param $template
     * @param null $type
     * @param $token
     * @param $token2
     * @param $token3
     * @param $token10
     */
    public function __construct($receptor, $template, $token, $token2, $token3, $token10, $type = null)
    {
        $this->receptor = $receptor;
        $this->template = $template;
        $this->type = $type;
        $this->token = $token;
        $this->token2 = $token2;
        $this->token3 = $token3;
        $this->token10 = $token10;
    }

    public function handle(): void
    {
        $api = new CustomKavenegarApi(config('pars-ticket.sms_api_key.kavenegar-url'));
        $api->VerifyLookupV2($this->receptor, $this->template, $this->type, $this->token, $this->token2, $this->token3, $this->token10);
    }
}
