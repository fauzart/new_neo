<?php
$redirect=false;
$cleartext=true;

include "inc.session.php";
include "inc.db.php";

$conn=connect();

$h=post("h",$conn);
$rs=exec_qry($conn,"select * from core_node where host='$h'");
$node=array();
if($row=fetch_assoc($rs)){
	$node=$row;
	$loc=$row["loc"];
	$rs=exec_qry($conn,"select * from core_location where locid='$loc'");
	$rows=fetch_alla($rs);
	$location=array();
	if(count($rows)>0) $location=$rows[0];
}
disconnect($conn);

if(count($node)>0){
?>
<div class="row">
	<div class="col-lg-3">
	<b>Host : </b><?php echo $node['host']?>
	</div>
	<div class="col-lg-3">
	<b>Name : </b><?php echo $node['name']?>
	</div>
	<div class="col-lg-2">
	<b>Network : </b><?php echo $node['net']?>
	</div>
	<div class="col-lg-2">
	<b>Type : </b><?php echo $node['typ']?>
	</div>
	<div class="col-lg-2">
	<b>Group : </b><?php echo $node['grp']?>
	</div>
</div>
<br />
<div class="row">
	<div class="col-lg-2">
	<b>Location : </b><?php echo $node['loc']?>
	</div>
<?php if(count($location)>0){?>
	<div class="col-lg-3">
	<b>Name : </b><?php echo $location['name']?>
	</div>
	<div class="col-lg-3">
	<b>Addr : </b><?php echo $location['addr']?>
	</div>
	<div class="col-lg-2">
	<b>City : </b><?php echo $location['city']?>
	</div>
	<div class="col-lg-2">
	<b>Province : </b><?php echo $location['prov']?>
	</div>
<?php }?>
</div>
<?php }else{ echo "Record not found"; }?>