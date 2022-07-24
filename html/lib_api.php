<?php
$redirect=false;

include "inc.common.php";
include "inc.session.php";

$lnk=base64_decode($_GET['lnk']);
$lib_url.=$lnk;

//echo $lib_url;

    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $lib_url);
	curl_setopt ($curl, CURLOPT_HEADER, false);
	curl_setopt ($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$lib_token));
    curl_exec ($curl);
    curl_close ($curl);
