<?php
$redirect=false;
$cleartext=true;

include "inc.session.php";
include "lib_inc.db.php";

$conn=connect();

$idx=post("idx",$conn);
$rs=exec_qry($conn,"select * from devices where device_id='$idx'");
$node=array();
if($row=fetch_assoc($rs)){
	$node=$row;
	$loc=$row["location_id"];
	$rs=exec_qry($conn,"select * from locations where id='$loc'");
	$rows=fetch_alla($rs);
	$location=array();
	if(count($rows)>0) $location=$rows[0];
}
disconnect($conn);

if(count($node)>0){
?>
<div class="row">
	<div class="col-lg-6">
	<b>Host : </b><?php echo $node['hostname']?>
	</div>
	<div class="col-lg-6">
	<b>sysName : </b><?php echo $node['sysName']?>
	</div>
</div>
<br />
<div class="row">
	<div class="col-lg-6">
	<b>sysDescr : </b><?php echo $node['sysDescr']?>
	</div>
	<div class="col-lg-6">
	<b>sysContact : </b><?php echo $node['sysContact']?>
	</div>
</div>
<br />
<div class="row">
	<div class="col-lg-6">
	<b>O/S Version : </b><?php echo $node['os']?> <?php echo $node['version']?>
	</div>
	<div class="col-lg-6">
	<b>Hardware : </b><?php echo $node['hardware']?>
	</div>
</div>
<br />
<?php if(count($location)>0){?>
<div class="row">
	<div class="col-lg-6">
	<b>Location : </b><?php echo $location['location']?>
	</div>
	<div class="col-lg-3">
	<b>Lat : </b><?php echo $location['lat']?>
	</div>
	<div class="col-lg-3">
	<b>Lng : </b><?php echo $location['lng']?>
	</div>
</div>
<?php }?>
<?php }else{ echo "Record not found"; }?>