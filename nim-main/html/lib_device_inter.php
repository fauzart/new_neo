<?php
$redirect=false;
$cleartext=true;

include "inc.common.php";
include "inc.session.php";
include "lib_inc.db.php";

$conn=connect();

$host=post('h');
$id=post('idx',$conn,0);

$sql="select ifName,ifDescr from ports where device_id=$id";
$rs=exec_qry($conn,$sql);
$ports=fetch_alla($rs);

disconnect($conn);

if(count($ports)>0){
	$endpoint="devices/".$host."/ports/";
?>
<div class="row">
	<?php
	for($i=0;$i<count($ports);$i++){
		$port=$ports[$i];
		$name=$port['ifName'];
		$desc=$port['ifDescr'];
		$isdescr=$name==""?"?ifDescr=true":"";
		$name=$name==""?$desc:$name;
		$lnk=base64_encode($endpoint.$name.'/port_bits'.$isdescr);
		//echo base64_decode($lnk);
	?>
		<div class="col-lg-6 text-center center">
			<?php echo $name==$desc?$name:$name." - ".$desc ?>
			<br />
			<a href="JavaScript:;" data-fancybox="" data-type="iframe" data-src="lib_device_graph<?php echo $ext?>?l=<?php echo $lnk?>&h=<?php echo $host?>&g=<?php echo $name?>">
				<img width="100%" src="lib_api<?php echo $ext?>?lnk=<?php echo $lnk?>" />
			</a>
		</div>
	<?php
	}
	?>
</div>
<?php
}else{
	echo "No Interface found.";
}
?>
