<?php

$key = htmlspecialchars($_POST['key'] ?? '');
$pathReguest = $_SERVER['DOCUMENT_ROOT'] . '/authorization/reguest.json';

$reguestArr = [];

if ( json_decode(file_get_contents($pathReguest), true) ) {
    $reguestArr = json_decode(file_get_contents($pathReguest), true);
}

if ( isset($_POST['submitKey']) ) {
    setcookie('key', $key, time() + (3600 * 24 * 365), '/');

    $reguestArr[] = ['date'=> date('d.m.Y H:i:s'), 'key'=> $key];

    file_put_contents( $pathReguest, json_encode($reguestArr) );
}

require $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/src/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/authorization/accesss-key.php';
