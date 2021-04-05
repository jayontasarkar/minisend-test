<?php

use GuzzleHttp\Client;

require 'vendor/autoload.php';

$client = $client = new Client();

// for ($i=11; $i <= 20; $i++) { 
//     $client->post('http://minisend-api.test/api/v1/emails', [
//         'multipart' => [
//             [
//                 'name'     => 'attachments[0]',
//                 'contents' => fopen('form.html', 'r'),
//             ],
//             [
//                 'name'     => 'attachments[1]',
//                 'contents' => fopen('form1.html', 'r'),
//             ],
//             [
//                 'name'     => 'sender',
//                 'contents' => 'sender@example.com',
//             ],
//             [
//                 'name'     => 'recipient',
//                 'contents' => "recipient{$i}@example.com",
//             ],
//             [
//                 'name'     => 'subject',
//                 'contents' => 'Subject of email ' . $i,
//             ],
//             [
//                 'name'     => 'text_content',
//                 'contents' => 'Text content of email ' . $i,
//             ],
//             [
//                 'name' => 'html_content',
//                 'contents' => '<h3>HTML content of email ' . $i . '<h3>'
//             ],
//             [
//                 'name' => 'x-api-key',
//                 'contents' => 'g5Q8596lkctVEPY13l2saX5gBWoyr31KuoMQQvRpjLxwYSDKQ7'
//             ]
//         ],
//     ]);
// }

$client->post('http://minisend-api.test/api/v1/emails', [
    'multipart' => [
        [
            'name'     => 'attachments[0]',
            'contents' => fopen('form.html', 'r'),
        ],
        [
            'name'     => 'attachments[1]',
            'contents' => fopen('form1.html', 'r'),
        ],
        [
            'name'     => 'sender',
            'contents' => 'sender@example.com',
        ],
        [
            'name'     => 'recipient',
            'contents' => "recipient@example.com",
        ],
        [
            'name'     => 'subject',
            'contents' => 'Subject of test email',
        ],
        [
            'name'     => 'text_content',
            'contents' => base64_encode('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w=
            3.org/TR/REC-html40/loose.dtd">
            <html><body>
            <p>Hello Jayonta,<br></p>
            <p>Thank you for your interest in working with us, we\'re happy to hear from=
             you!</p>
            <p>Our team is looking forward to getting to know you better and they prepa=
            red a <a href=3D"https://docs.google.com/document/d/1jBut-Fy7U4CaLPQql59NLi=
            9-pmzDsn1toZDPIdYBb_4/edit" target=3D"_blank" rel=3D"noopener noreferrer no=
            follow">test assignment</a> so you can show how awesome you are. The files =
            should be put in a publicly accessible GIT repository (please no zip files =
            or private repos) and it would be great if you could let me know how much t=
            ime you need for completing it.</p>
            <p>Thank you and please do not hesitate to get in touch if you have any questions.<br><br>Best of luck with the assignment,</p>
            <hr>
            <p><strong>Izabella Dima<br></strong>HR Manager at <a href=3D"https://www.r=
            emotecompany.com/" target=3D"_blank" rel=3D"noopener noreferrer nofollow"><
            strong>The Remote Company</strong></a></p>
            </body></html>'),
        ],
        [
            'name' => 'html_content',
            'contents' => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w=
            3.org/TR/REC-html40/loose.dtd">
            <html><body>
            <p>Hello Jayonta,<br></p>
            <p>Thank you for your interest in working with us, we\'re happy to hear from=
             you!</p>
            <p>Our team is looking forward to getting to know you better and they prepa=
            red a <a href=3D"https://docs.google.com/document/d/1jBut-Fy7U4CaLPQql59NLi=
            9-pmzDsn1toZDPIdYBb_4/edit" target=3D"_blank" rel=3D"noopener noreferrer no=
            follow">test assignment</a> so you can show how awesome you are. The files =
            should be put in a publicly accessible GIT repository (please no zip files =
            or private repos) and it would be great if you could let me know how much t=
            ime you need for completing it.</p>
            <p>Thank you and please do not hesitate to get in touch if you have any questions.<br><br>Best of luck with the assignment,</p>
            <hr>
            <p><strong>Izabella Dima<br></strong>HR Manager at <a href=3D"https://www.r=
            emotecompany.com/" target=3D"_blank" rel=3D"noopener noreferrer nofollow"><
            strong>The Remote Company</strong></a></p>
            </body></html>'
        ],
        [
            'name' => 'x-api-key',
            'contents' => 'g5Q8596lkctVEPY13l2saX5gBWoyr31KuoMQQvRpjLxwYSDKQ7'
        ]
    ],
]);

