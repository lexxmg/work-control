<?php

require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

// $key = $_COOKIE['key'] ?? '';
// $access = false;
//
// foreach ($arrAccessKey as $i => $value) {
//     if ($value['key'] == $key) {
//         $access = true;
//         break;
//     }
// }

if ($access) {
    header("Location: /");
    exit;
} else {
    require $_SERVER['DOCUMENT_ROOT'] . '/templates/auth.php';
}

require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
