<?php

require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

if ($_SERVER['REMOTE_ADDR'] == ACCESS_IP) {
    echo 'доступ разрешон';
} else {
    header("Location: /route/auth");
    exit;
}

require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
