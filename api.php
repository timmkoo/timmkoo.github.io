<?php

$dl = $_GET['download'] ?? '';

if (!preg_match('/^[a-zA-Z0-9]{1,30}$/', $dl)) {
    http_response_code(400);
    die;
}

function encode10x($input) {
    $encoded = $input;
    for ($i = 1; $i <= 10; $i++) {
        $encoded = base64_encode($encoded);
    }
    return $encoded;
}

if ($dl == 'mtkdriver') {
    $link = "https://google.com";
    $encodedLink = encode10x($link);
    echo "$encodedLink";
} elseif ($dl == '2') {
    echo "Option 2 gewählt";
} else {
    echo 'Error';
    
}

?>