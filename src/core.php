<?php

$pathReguest = $_SERVER['DOCUMENT_ROOT'] . '/authorization/reguest.json';
$pathAccessKey = $_SERVER['DOCUMENT_ROOT'] . '/authorization/accesss-key.json';
$pathOutName = $_SERVER['DOCUMENT_ROOT'] . '/authorization/out-name.json';

$reguestArr = [];
$arrAccessKey = [];
$outName = [];

$key = explode(':', htmlspecialchars($_POST['key'] ?? ''));


if ( json_decode(file_get_contents($pathReguest), true) ) {
    $reguestArr = json_decode(file_get_contents($pathReguest), true);
}

if ( json_decode(file_get_contents($pathAccessKey), true) ) {
    $arrAccessKey = json_decode(file_get_contents($pathAccessKey), true);
}

if ( json_decode(file_get_contents($pathOutName), true) ) {
    $outName = json_decode(file_get_contents($pathOutName), true);
}

if ( isset($_POST['submitKey']) && count($key) == 2 && $key[0] == 'key' && $key[1] != '' ) {
    setcookie('key', $key[1], time() + (3600 * 24 * 365), '/');

    $reguestArr[] = ['date'=> date('d.m.Y H:i:s'), 'key'=> $key[1]];

    file_put_contents( $pathReguest, json_encode($reguestArr, JSON_UNESCAPED_UNICODE) );
}

require $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/src/functions.php';
