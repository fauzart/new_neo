<?php
session_start();

$s_ID = isset($_SESSION['s_ID'])? $_SESSION['s_ID'] : "";
$s_NAME = isset($_SESSION['s_NAME'])? $_SESSION['s_NAME'] : "";
$s_LVL = isset($_SESSION['s_LVL'])? $_SESSION['s_LVL'] : "";
$s_GRP = isset($_SESSION['s_GRP'])? $_SESSION['s_GRP'] : "";
$s_AVATAR = isset($_SESSION['s_AVATAR'])? $_SESSION['s_AVATAR'] : "";
$s_PROF = isset($_SESSION['s_PROF'])? $_SESSION['s_PROF'] : "";

$redir=isset($redirect)?$redirect:true;
$dttbl=isset($datatable)?$datatable:false;
$noformat=isset($cleartext)?$cleartext:false;

if($s_ID==""){
	if($redir){
		header("Location: index$ext?x=error&m=Please login.");
	}else{
		if($noformat){
			echo "Session Expired. Please Login";
		}else{
			if($dttbl){
				$output = array(
				  "draw"=>1,
				  "recordsTotal"=>0, // total number of records 
				  "recordsFiltered"=>0, // if filtered data used then tot after filter
				  "data"=>array(),
				  "msgs"=>"Session expired"
				);
				echo json_encode($output);
			}else{
				echo json_encode(array('code'=>"403",'ttl'=>"Error",'msgs'=>"Session Expired. Please Login"));
			}
		}
		exit;
	}
}//end if

if(isset($restrict_grp)){
	if($s_GRP!=""){
		if(!in_array($s_GRP,$restrict_grp)){
			header("Location: error$ext?m=You are not alowed to access this page.");
		}
	}
}
if(isset($restrict_lvl)){
	if($s_LVL!=""){
		if(!in_array($s_LVL,$restrict_lvl)){
			header("Location: error$ext?m=You are not alowed to access this page.");
		}
	}
}
