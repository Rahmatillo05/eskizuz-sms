<?php

use rahmatullo\eskizsms\Eskiz;

require "vendor/autoload.php";

$eskiz = new Eskiz("your_email@mail.com", "your_password");

$options_for_batch = [
    'messages' => [
        [
            'to' => 'phone_number_1',
            'text' => 'Your message'
        ],
        [
            'to' => 'phone_number_1',
            'text' => 'Your message'
        ]
    ],
    "from" => "Your nickname | Default 4546",
    'dispatch_id' => 'Your dispatch_id'
];

$options_for_single = [
    'mobile_phone' => 'phone_number',
    'message' => 'Your message',
    'from ' => 'Your nickname | Default 4546'
];


/*
 * Authorization tokenini olish
 */
$eskiz->getToken();


/*
 * User ma'lumotlarini olish uchun
 */
$eskiz->getUserData();


/*
 * Single SMS jo'natish uchun
 */
$eskiz->smsSend($options_for_single);


/*
 * Batch SMS jo'natish uchun
 */
$eskiz->sendSmsBatch($options_for_batch);


/*
 * Yuborilgan barcha xabarlarni olish
 */
$eskiz->getMessages();


/*
 * Xabarlarning  holatini ko'rish
 */
$eskiz->getMessageStatus('your_dispatch_id');

?>
