<?php
$redirect=false;
include "inc.common.php";
include "inc.session.php";
include 'inc.db.php';

require_once('lib/SubnetCalculator.php');

$code='404';
$ttl='Error';
$msgs='Action not found';

$conn = connect();

$mn=post('mnu',$conn);

if($mn=='passwd'){
	$opwd=post('op',$conn);
	$npwd=post('np',$conn);
	$sql=sql_update("core_user","","uid='$s_ID' and upwd=md5('$opwd')",$conn,"upwd","md5('$npwd')");
	$rs=exec_qry($conn,$sql);
	if(db_error($conn)==''){
		if(affected_row($conn)>0){
			$code='200'; $ttl='Success'; $msgs='Password changed';
		}else{
			$code='204'; $ttl='Failed'; $msgs='Invalid old password';
		}
	}else{
		$code='201'; $ttl='Error'; $msgs="Error accessing data";
		if(!$production){$msgs.=$sql;}
	}
}
if($mn=='user'){
	$passwd=post('pwd');
	$fcols=$passwd==''?'':'upwd';
	$fvals=$passwd==''?"":"md5('$passwd')";
	$res=crud($conn,$fcols,$fvals);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='profile'){
	$up=upload_file("favatar","avatars/",$s_ID);
	$avatar=$up[0]&&$up[1]!=''?$up[1]:'';
	$favatar=$avatar==''?'':'uavatar';
	$res=crud($conn,"$favatar","'$avatar'");
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
	if($s_AVATAR==''){
		$_SESSION['s_AVATAR']=$avatar;
	}
}
if($mn=='ravatar'){
	$files=glob("avatars/$s_ID.*");
	if(count($files)>0){
		if(unlink($files[0])){
			$_SESSION['s_AVATAR']='';
			$res=array("200","Success","Picture removed");
		}else{
			$res=array("201","Error","Remove picture failed");
		}
	}else{
		$res=array("201","Error","Picture does not exist");
	}
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}


if($mn=='severity'){
	$res=crud($conn);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='sla'){
	$res=crud($conn);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='location'){
	$res=crud($conn);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='location_batch'){
	$res=batch_input($conn,"locid");
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='mbg'){
	$res=crud($conn);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='mdevice'){
	$res=crud($conn);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='mdevice_batch'){
	$res=batch_input($conn,"host");
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}

if($mn=='ip'){
	$name=post('name');
	$mask=post('subnet');
	$subs = explode("/",$mask);
	if(count($subs)<2){
		$msgs="Wrong format"; $code="201"; $ttl="Error";
	}else{
		if (filter_var($subs[0], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)&&filter_var($subs[1], FILTER_VALIDATE_INT)) {
			$sub = new IPv4\SubnetCalculator($subs[0],$subs[1]);
			$res = $sub->getSubnetArrayReport();
			$s=$res['ip_address_range'][0]; $e=$res['ip_address_range'][1]; $t=$res['number_of_ip_addresses'];
			$res=crud($conn,"ipstart,ipstop,tot","'$s','$e','$t'");
			$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
			
		}else{
			$msgs="Invalid IP"; $code="202"; $ttl="Error";
		}
	}
}


if($mn=='attachment'){
	$up=upload_file("ffile","uploads/");
	$sv=post('sv');
	$fname=$up[0]&&$up[1]!=''?$up[1]:post('fname');
	if($sv=='NEW'){
		$fname=$up[0]&&$up[1]!=''?$up[1]:'';
	}
	$res=crud($conn,"fname,lastupd,updby","'$fname',now(),'$s_ID'");
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}

if($mn=='posting'){
	$paydt=nullpost('paydt');
	$revdt=nullpost('reversedt');
	$res=crud($conn,"paydt,reversedt","$paydt,$revdt");
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='posting_batch'){
	$res=batch_input($conn,"sapdocid","paydt,reversedt,billdt");
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}


disconnect($conn);

echo json_encode(array('code'=>$code,'ttl'=>$ttl,'msgs'=>$msgs));
?>