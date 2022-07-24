<?php
$redirect=false;
$cleartext=true;

include "inc.common.php";
include "inc.session.php";
include "inc.db.php";

$conn=connect();

$host=post("h",$conn);
$rs=exec_qry($conn,"select * from core_node where host='$host'");
$node=array();
if($row=fetch_assoc($rs)){
	$node=$row;
}

disconnect($conn);

$h='0'; $h2='23';
$i='0'; $i2='59';
$s='0'; $s2='59';
$y=date("Y");
$m=date("m");
$d=date("d");

$dari=mktime($h,$i,$s,$m,$d,$y);
$sampai=mktime($h2,$i2,$s2,$m,$d,$y);

if(count($node)>0){
	$count=$node["ping_count"]/100;
?>
<div class="row">
	<div class="col-lg-6"><a href="JavaScript:;" data-fancybox="" data-type="iframe" data-src="device_graph<?php echo $ext?>?graph=rtt&h=<?php echo $host?>">
	<img src="/cgi-bin/rtt.sh?h=<?php echo $host?>&b=<?php echo $dari?>&e=<?php echo $sampai?>">
	</a></div>
	<div class="col-lg-6"><a href="JavaScript:;" data-fancybox="" data-type="iframe" data-src="device_graph<?php echo $ext?>?graph=jitter&h=<?php echo $host?>">
	<img src="/cgi-bin/mdev.sh?h=<?php echo $host?>&b=<?php echo $dari?>&e=<?php echo $sampai?>">
	</a></div>
</div>
<br />
<div class="row">
	<div class="col-lg-6"><a href="JavaScript:;" data-fancybox="" data-type="iframe" data-src="device_graph<?php echo $ext?>?graph=lost&h=<?php echo $host?>&c=<?php echo $count?>">
	<img src="/cgi-bin/lost.sh?h=<?php echo $host?>&b=<?php echo $dari?>&e=<?php echo $sampai?>&c=<?php echo $count?>">
	</a></div>
</div>
<?php }else{ echo "Record not found"; }?>