<pre>
<?php

use rahmatullo\eskizsms\Eskiz;

require "vendor/autoload.php";

$eskiz = new Eskiz("hrrahmatillo2oo5@gmail.com", "RfHUBE87ZnDLSBcFMBr48GJoNQkDeOC6gt5sEEYq");

$options = [
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

$options2 = [
    'mobile_phone' => 'phone_number',
    'message' => 'Your message',
    'from ' => 'Your nickname | Default 4546'
];


?>
</pre>