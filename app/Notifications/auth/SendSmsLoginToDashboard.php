<?php

namespace App\Notifications\auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SendSmsLoginToDashboard extends Notification
{
    use Queueable;

    private $client;
    private string $userSmsPanel;
    private string $passwordSmsPanel;
    private string $fromNumberSmsPanel;
    private array $mobilesNumber;
    private string $patternCode;
    private array $inputData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mobilesNumber, $loginCode)
    {
        $this->client = new \SoapClient(env('FARAZ_SMS_URL'));
        $this->userSmsPanel = env('FARAZ_SMS_USER');
        $this->passwordSmsPanel = env('FARAZ_SMS_PASSWORD');
        $this->fromNumberSmsPanel = env('FARAZ_SMS_FROM_NUMBER');
        $this->patternCode = env('FARAZ_SMS_CODE_LOGIN_PATTERN');

        $this->mobilesNumber = $mobilesNumber;
        $this->inputData = array("verification-code" => $loginCode);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $mobile = $this->mobilesNumber;
        if (app()->environment() == 'local') {
            $mobile = env("MOBILE_NUMBER_FOR_DEVELOP_MODE");
        };
        return;
        $this->client->sendPatternSms(
            $this->fromNumberSmsPanel,
            $mobile,
            $this->userSmsPanel,
            $this->passwordSmsPanel,
            $this->patternCode,
            $this->inputData);
    }

}
