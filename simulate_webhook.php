<?php

$data = [
    "transaction_id" => "TXN123456",
    "status" => "success",
    "member_id" => 1
];

$options = [
    "http" => [
        "header"  => "Content-type: application/json",
        "method"  => "POST",
        "content" => json_encode($data),
    ]
];

$context = stream_context_create($options);
$result = file_get_contents("http://localhost/bishnu/webhook.php", true, $context);

echo $result;
?>
