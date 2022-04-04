<?php

$keyCookie = $_COOKIE['key'] ?? '';
$access = false;
$first = false;
$admin = false;
$out = '';

$pathReguest = $_SERVER['DOCUMENT_ROOT'] . '/authorization/reguest.json';
$pathAccessKey = $_SERVER['DOCUMENT_ROOT'] . '/authorization/accesss-key.json';
$pathOutName = $_SERVER['DOCUMENT_ROOT'] . '/authorization/out-name.json';

$reguestArr = [];
$arrAccessKey = [];
$outName = [
    '1' => [
        'name' => 'out-1',
        'rev' => false
    ],
    '2' => [
        'name' => 'out-2',
        'rev' => false
    ],
    '3' => [
        'name' => 'out-3',
        'rev' => false
    ],
    '4' => [
        'name' => 'out-4',
        'rev' => false
    ],
    '5' => [
        'name' => 'out-5',
        'rev' => false
    ],
    '6' => [
        'name' => 'out-6',
        'rev' => false
    ],
    '7' => [
        'name' => 'out-7',
        'rev' => false
    ],
    '8' => [
        'name' => 'out-8',
        'rev' => false
    ],
    '9' => [
        'name' => 'out-9',
        'rev' => false
    ],
    '10' => [
        'name' => 'out-10',
        'rev' => false
    ],
    '11' => [
        'name' => 'out-11',
        'rev' => false
    ],
    '12' => [
        'name' => 'out-12',
        'rev' => false
    ]
];

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


foreach ($arrAccessKey as $i => $value) {
    if ($value['key'] == $keyCookie) {
        $access = true;
        $first = $value['first'];
        $admin = $value['admin'];
        $out = $value['out'];
        break;
    }
}

require $_SERVER['DOCUMENT_ROOT'] . '/src/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/src/functions.php';
