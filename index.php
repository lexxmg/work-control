
<?php
require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');

if ($access) {
    require $_SERVER['DOCUMENT_ROOT'] . '/templates/control.php';
} else {
    setcookie("key", $key, 1, '/');

    header("Location: /route/auth");
    exit;
}

require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
