
<?php
require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');

$key = $_COOKIE['key'] ?? '';
$access = false;

foreach ($arrAccessKey as $i => $value) {
    if ($value['key'] == $key) {
        $access = true;
        break;
    }
}

if ($access) {
    require $_SERVER['DOCUMENT_ROOT'] . '/templates/control.php';
} else {
    setcookie("key", $key, 1, '/');

    header("Location: /route/auth");
    exit;
}

require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
