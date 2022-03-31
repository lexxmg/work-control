<?php
	// состояние JSON http://192.168.0.15/lexx/myHome/php/laurent.php?ip=192.168.0.101
	// управление http://192.168.0.15/lexx/myHome/php/laurent.php?ip=192.168.0.101&out=4&st=off

// if (getallheaders()["Authorization"] != 'Bearer 123') {
//   http_response_code(404);
//   exit;
// }
require $_SERVER['DOCUMENT_ROOT'] . '/authorization/accesss-key.php';

$key = $_COOKIE['key'] ?? '';
$access = false;

foreach ($accessKeys as $i => $value) {
    if ($value['key'] == $key) {
        $access = true;
        break;
    }
}

if (!$access) {
    http_response_code(404);
    exit;
}

if (count($_GET) == 1) {
  	$res = file_get_contents("http://" . $_GET['ip'] . "/status.xml");
  	$xml = simplexml_load_string($res);
  	echo json_encode($xml);
}

if (count($_GET) > 1) {
  	$res = file_get_contents("http://" . $_GET['ip'] . "/status.xml");
  	$xml = simplexml_load_string($res);
  	$out = $xml -> out_table0;

  	if (!empty($_GET['out']) && !empty($_GET['st'])) {
    		if($_GET['st'] == 'on' && mb_substr($out, $_GET['out'] - 1, 1) == 0) {
    			   $resOut = file_get_contents("http://" . $_GET['ip'] . "/server.cgi?data=OUT," . $_GET['out']);
    			   echo "$resOut";
  	    }

    		if ($_GET['st'] == 'off' && mb_substr($out, $_GET['out'] - 1, 1) == 1) {
      			$resOut = file_get_contents("http://" . $_GET['ip'] . "/server.cgi?data=OUT," . $_GET['out']);
      			echo "$resOut";
    		}

    		if ($_GET['st'] == 'toggle') {
      			$resOut = file_get_contents("http://" . $_GET['ip'] . "/server.cgi?data=OUT," . $_GET['out']);
      			echo "$resOut";
    		}

    		if ($_GET['st'] == 'auto') {
      			if (mb_substr($out, $_GET['out'] - 1, 1) == 1) {
      				    file_get_contents("http://" . $_GET['ip'] . "/server.cgi?data=OUT," . $_GET['out']);
      			}

      			if (mb_substr($out, $_GET['out'] - 1, 1) == 0){
    				    $resOut = file_get_contents("http://" . $_GET['ip'] . "/server.cgi?data=OUT," . $_GET['out']);

        				if($resOut == "Success! DONE") {
        					echo "OK";
        					usleep(500000);
        					file_get_contents("http://" . $_GET['ip'] . "/server.cgi?data=OUT," . $_GET['out']);
        				}
      			}
    		}
  	}
}
