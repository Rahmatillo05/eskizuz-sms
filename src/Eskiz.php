<?php

namespace rahmatullo\eskizsms;


use Curl\Curl;
use ErrorException;

class Eskiz
{
    public Curl $client;
    protected string $base_url = "https://notify.eskiz.uz/api/";
    private string $token;
    private int $user_id;

    /**
     * @throws ErrorException
     */
    public function __construct(
        public string $email,
        public string $password
    )
    {
        $this->client = new Curl();
        $this->token = $this->getToken();
        $this->client->setHeader("Authorization", "Bearer {$this->token}");
        $this->user_id = $this->setUserId();
    }

    /**
     * @throws ErrorException
     */
    public function getToken(): string
    {
        $action = $this->createUrl('auth/login');
        $res = $this->client->post($action, [
            'email' => $this->email,
            'password' => $this->password
        ]);
        $res = get_object_vars($res);
        if (isset($res['data'])) {
            return $res['data']->token;
        }
        throw new ErrorException($res['message']);
    }

    public function getUserData(): array
    {
        $action = $this->createUrl('auth/user');
        return (array)$this->client->get($action);
    }

    /**
     * @throws ErrorException
     */
    private function setUserId(): int
    {
        $user_data = $this->getUserData();
        if (isset($user_data['id'])) {
            return (int) $user_data['id'];
        }
        throw new ErrorException($user_data['message']);
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }
    private function createUrl(string $action): string
    {
        return $this->base_url.$action;
    }
    /**
     * @param array $options
     * Sizning xabar sozlamaringiz hisoblanadi
     *
     * $options = [
     *     'mobile_phone' => 'recipient's phone number',
     *     'message' => 'Your message',
     *     'from ' => 'Sender nickname | Default 4546',
     *     'callback_url' => 'Your Callback url | Optional'
     * ]
     * More information https://documenter.getpostman.com/view/663428/TVK5eMco#97796848-1254-4460-a690-3ba68080cf55
     * @return array
     */
    public function smsSend(array $options): array
    {
        $action = $this->createUrl('message/sms/send');
        $options['mobile_phone'] = $this->sanitizePhone($options['mobile_phone']);
        $options['user_sms_id'] = $this->user_id;
        return (array) $this->client->post($action, $options);
    }

    public function getMessages(string $start_date = '2023-01-01 00:00', string $end_date = '2024-01-01 00:00')
    {
        $action = $this->createUrl('message/sms/get-user-messages');
        return $this->client->post($action, compact('start_date', 'end_date'));
    }

    public function getMessageStatus(string $message_id)
    {
        $action = $this->createUrl('message/sms/get-dispatch-status');

        return $this->client->post($action, [
            'user_id' => $this->user_id,
            'dispatch_id' => $message_id
        ]);
    }

    public function sendSmsBatch(array $options)
    {
        $action = $this->createUrl('message/sms/send-batch');
        return $this->client->post($action, $options);
    }

    public function sanitizePhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }
    
}