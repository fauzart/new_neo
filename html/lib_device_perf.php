<?php
$redirect=false;
$cleartext=true;

include "inc.common.php";
include "inc.session.php";
include "lib_inc.db.php";

$conn=connect();

$host=post('h');
$id=post('idx',$conn,0);

disconnect($conn);

$lib_url.="devices/$host/health";
$out=lib_api($lib_token,$lib_url);

//echo $out;

$output=json_decode($out);
$healths=$output->graphs;

if(count($healths)>0){
	$endpoint="devices/".$host."/graphs/health/";
?>
<div class="row">
	<?php
	for($i=0;$i<count($healths);$i++){
		$health=$healths[$i];
		$name=$health->name;
		$desc=$health->desc;
		$lnk=base64_encode($endpoint.$name);
		//echo base64_decode($lnk);
	?>
		<div class="col-lg-6 text-center center">
			<?php echo $desc ?>
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
	echo "No Health found.";
}
?>
