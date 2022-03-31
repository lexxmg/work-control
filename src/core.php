<?php

$key = htmlspecialchars($_POST['key'] ?? '');

if ( isset($_POST['submitKey']) ) {
    setcookie('key', $key, time() + (3600 * 24 * 365), '/');
}

require $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/src/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/authorization/accesss-key.php';
