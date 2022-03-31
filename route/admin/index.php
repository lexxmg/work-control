<?php

require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

if ($_SERVER['REMOTE_ADDR'] == ACCESS_IP) {
    echo 'доступ разрешон';
} else {
    header("Location: /route/auth");
    exit;
}

$pathReguest = $_SERVER['DOCUMENT_ROOT'] . '/authorization/reguest.json';

var_dump( json_decode(file_get_contents($pathReguest), true) );

require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
