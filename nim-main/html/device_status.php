<?php
$redirect=false;
$cleartext=true;

include "inc.session.php";
include "inc.db.php";

$conn=connect();

$h=post("h",$conn);
$rs=exec_qry($conn,"select * from core_status where host='$h'");
$status=array();
$mrtt=100;
$mjit=100;
if($row=fetch_assoc($rs)){
	$status=$row;
	$rs=exec_qry($conn,"select max(rtt), max(mdev) from core_status");
	if($row=fetch_row($rs)){
		$mrtt=$row[0]; $mjit=$row[1];
	}
}
disconnect($conn);

if(count($status)>0){
?>
<div class="row">
	<div class="col-md-3 text-center mb-4 mb-md-0">
		<p class="data-attributes mb-0">
			<span class="pie" data-peity="{ &quot;fill&quot;: [&quot;#66f72d&quot;, &quot;#e5e9f2&quot;]}" style="display: none;"><?php echo $status["uptime"] ?>/<?php echo ($status["uptime"]+$status["downtime"]) ?></span>
		</p>
		<h4 class=" mb-0 font-weight-semibold"><?php echo round($status["uptime"]/($status["uptime"]+$status["downtime"])*100,2) ?>%</h4>
		<p class="mb-0 text-muted">Uptime</p>
	</div>
	<div class="col-md-3 text-center mb-4 mb-md-0">
		<p class="data-attributes mb-0">
			<span class="donut" data-peity="{ &quot;fill&quot;: [&quot;#4a32d4&quot;, &quot;#e5e9f2&quot;]}" style="display: none;"><?php echo $status["rtt"] ?>/<?php echo $mrtt ?></span>
		</p>
		<h4 class=" mb-0 font-weight-semibold"><?php echo $status["rtt"] ?>ms</h4>
		<p class="mb-0 text-muted">Ping RTT</p>
	</div>
	<div class="col-md-3 text-center">
		<p class="data-attributes mb-0">
			<span class="donut" data-peity="{ &quot;fill&quot;: [&quot;#f7be2d&quot;, &quot;#e5e9f2&quot;]}" style="display: none;"><?php echo $status["mdev"] ?>/<?php echo $mjit ?></span>
		</p>
		<h4 class=" mb-0 font-weight-semibold"><?php echo $status["mdev"] ?>ms</h4>
		<p class="mb-0 text-muted">Jitter</p>
	</div>
	<div class="col-md-3 text-center mb-4 mb-md-0">
		<p class="data-attributes mb-0">
			<span class="donut" data-peity="{ &quot;fill&quot;: [&quot;#fb1c52&quot;, &quot;#e5e9f2&quot;]}" style="display: none;"><?php echo $status["lost"] ?>/<?php echo $status["cnt"] ?></span>
		</p>
		<h4 class=" mb-0 font-weight-semibold"><?php echo round($status["lost"]/$status["cnt"]*100,2) ?>%</h4>
		<p class="mb-0 text-muted">Loss</p>
	</div>
</div>
<?php }else{ echo "Record not found"; }?>

<script>
 $('span.donut').peity('donut',{
        width: '50',
        height: '50'
    });
 $('span.pie').peity('pie',{
        width: '50',
        height: '50'
    })
</script>