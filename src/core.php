<?php

$pathReguest = $_SERVER['DOCUMENT_ROOT'] . '/authorization/reguest.json';
$pathAccessKey = $_SERVER['DOCUMENT_ROOT'] . '/authorization/accesss-key.json';

$reguestArr = [];
$arrAccessKey = [];

$outName = [
    '1' => 'out-1',
    '2' => 'out-2',
    '3' => 'out-3',
    '4' => 'Свет право-4',
    '5' => 'out-5',
    '6' => 'Свет под кроватью -6',
    '7' => 'out-7',
    '8' => 'out-8',
    '9' => 'Цветы-9',
    '10' => 'out-10',
    '11' => 'out-11',
    '12' => 'out-12',
];

$key = explode(':', htmlspecialchars($_POST['key'] ?? ''));


if ( json_decode(file_get_contents($pathReguest), true) ) {
    $reguestArr = json_decode(file_get_contents($pathReguest), true);
}

if ( json_decode(file_get_contents($pathAccessKey), true) ) {
    $arrAccessKey = json_decode(file_get_contents($pathAccessKey), true);
}

if ( isset($_POST['submitKey']) && count($key) == 2 && $key[0] == 'key' && $key[1] != '' ) {
    setcookie('key', $key[1], time() + (3600 * 24 * 365), '/');

    $reguestArr[] = ['date'=> date('d.m.Y H:i:s'), 'key'=> $key[1]];

    file_put_contents( $pathReguest, json_encode($reguestArr, JSON_UNESCAPED_UNICODE) );
}

require $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/src/functions.php';
