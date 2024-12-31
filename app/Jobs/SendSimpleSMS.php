<?php

namespace App\Jobs;

use App\Services\CustomKavenegarApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSimpleSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;

    protected $from;

    protected $date;

    protected $type;

    protected $message;

    protected $localid;

    /**
     * SendSimpleSMS constructor.
     * @param string $from
     * @param array $to
     * @param string $message
     * @param null $date
     * @param null $type
     * @param null $localid
     */
    public function __construct(?string $from, array $to, string $message, $date = null, $type = null, $localid = null)
    {
        $this->to = $to;
        $this->from = $from;
        $this->date = $date;
        $this->type = $type;
        $this->message = $message;
        $this->localid = $localid;
    }

    public function handle(): void
    {
        $api = new CustomKavenegarApi(config('pars-ticket.sms_api_key.kavenegar-url'));
        $api->VerifyLookupV2Simple($this->from, $this->to, $this->message, $this->date, $this->type, $this->localid);
    }
}
