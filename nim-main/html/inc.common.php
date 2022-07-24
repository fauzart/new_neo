<?php
$ext=".php";
date_default_timezone_set("Asia/Jakarta");

$theme="hor-skin/horizontal-dark.css"; //hor-skin/hor-skin1.css
$theme="hor-skin/hor-skin1.css";

$lib_url="http://localhost:8080/api/v0/";
$lib_token="8997ec42d0c502a67cce02e2be64f333";

$company="Matrik, PT";
$about=array(base64_encode("Network Information & Monitoring System"), base64_encode("Licensed to $company"));

/*common values*/
$o_ugrp=[
	["","All"],
	["commercial","Commercial"],
	["billing","Billing Admin"],
	["finance","Finance/Collection"]
];
$o_ulvl=[
	["0","Super"],
	["1","Admin"],
	["11","User"]
];

$o_days=[
	["","-"],
	["0","Mon"],
	["1","Tue"],
	["2","Wed"],
	["3","Thu"],
	["4","Fri"],
	["5","Sat"],
	["6","Sun"]
];

$o_ssensor=[
	["status","On/Off Status"],
	["rtt","Ping RTT"],
	["mdev","Ping Jitter"],
	["lost/cnt","Ping Lost"]
];
$o_sseverity=[
	["minor","Minor"],
	["major","Major"],
	["critical","Critical"]
];


/*common php functions*/
function getVal($k,$kv){
	$ret="";
	for($i=0;$i<count($kv);$i++){
		if($kv[$i][0]==$k) $ret=$kv[$i][1];
	}
	return $ret;
}
function options($kv){
	$ret="";
	for($i=0;$i<count($kv);$i++){
		$ret.='<option value="'.$kv[$i][0].'">'.$kv[$i][1].'</option>';
	}
	return $ret;
}
function multiple_select($f){
	$return="";
	for($i=0;$i<count($_POST[$f]);$i++){
		$return.=$return==""?"":";";
		$return.=$_POST[$f][$i];
	}
	return $return;
}
function breadcrumb($bread,$s='/'){
	$a=explode($s,$bread);
	$r="";
	for($i=0;$i<count($a);$i++){
		$r.='<li class="breadcrumb-item">'.$a[$i].'</li>';
	}
	return $r;
}

function lib_api($lib_token,$lib_url){
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $lib_url);
	curl_setopt ($curl, CURLOPT_HEADER, false);
	curl_setopt ($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$lib_token));
	curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    $out=curl_exec ($curl);
    curl_close ($curl);
	return $out;
}

function compare($o,$n,$fix,$highlow=true){
	$ret="0%$fix";
	$d=$o==0?$n:$o;
	if($o>$n){
		$hl=$highlow?" lower ":"";
		$ret=round(($o-$n)/$o*100,2)."%$hl$fix";
	}
	if($o<$n){
		$hl=$highlow?" higher ":"";
		$ret=round(($n-$o)/$d*100,2)."%$hl$fix";
	}
	return $ret;
}
function compare_class($o,$n,$dclass,$hclass,$lclass){
	$ret=$dclass;
	if($n>$o){
		$ret=$hclass;
	}
	if($n<$o){
		$ret=$lclass;
	}
	return $ret;
}
function progress_bar($o,$fix,$t=-1){
	if($t==-1){
		$ret=ceil($o/10)*10;
	}else{
		$ret=ceil(($o/$t*100)/10)*10;
	}
	return '<div class="progress-bar '.$fix.' w-'.$ret.' " role="progressbar"></div>';
}