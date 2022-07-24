<?php
$redirect=false;

include "inc.common.php";
include "inc.session.php";
include "inc.db.php";

$conn=connect();

$yearweeks=array();
$sql="select DISTINCT YEARWEEK(dt) as yw from core_status_sla where YEARWEEK(dt)>=YEARWEEK(CURRENT_DATE - INTERVAL 12 WEEK) order by YEARWEEK(dt)";
$rs=exec_qry($conn,$sql);
$recs=fetch_alla($rs);
for($i=0;$i<count($recs);$i++){
	$rec=$recs[$i];
	$yearweeks[$rec['yw']]=0;
}

//echo json_encode(array_keys($yearweeks));

$sql="select * from core_severity";
$rs=exec_qry($conn,$sql);
$severities=fetch_alla($rs);

$major=0;
$minor=0;
$critical=0;
$total=0;

$critlastmonth=0;
$critthismonth=0;

$critthisweek=0;
$majorthisweek=0;
$minorthisweek=0;

$critlastweek=0;
$majorlastweek=0;
$minorlastweek=0;

for($i=0;$i<count($severities);$i++){
	$severity=$severities[$i];
	$fld=$severity['sensor'];
	$net=$severity['net'];
	$min=$severity['mn'];
	$max=$severity['mx'];
	$svr=$severity['severity'];
	$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
	$sql="select count(host) from core_status where $fld>=$min and $fld<=$max $sql";
	$rs=exec_qry($conn,$sql);
	if($row=fetch_row($rs)){
		$total+=$row[0];
		switch($svr){
			case "major": $major+=$row[0]; break;
			case "minor": $minor+=$row[0]; break;
			case "critical": $critical+=$row[0]; break;
		}
	}
	$where="YEARWEEK(dt)>=YEARWEEK(CURRENT_DATE - INTERVAL 12 WEEK)";
	$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
	$sql="select YEARWEEK(dt),count(host) from core_status_sla where $where and $fld>=$min and $fld<=$max $sql group by YEARWEEK(dt)";
	$rs=exec_qry($conn,$sql);
	while($row=fetch_row($rs)){
		$yearweeks[$row[0]]+=$row[1];
	}
	
	if($svr=="critical"){
		$where="YEAR(dt) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(dt) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)";
		$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
		$sql="select count(host) from core_status_sla where $where and $fld>=$min and $fld<=$max $sql";
		$rs=exec_qry($conn,$sql);
		if($row=fetch_row($rs)){
			$critlastmonth+=$row[0];
		}
		$where="YEAR(dt) = YEAR(CURRENT_DATE) AND MONTH(dt) = MONTH(CURRENT_DATE)";
		$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
		$sql="select count(host) from core_status_sla where $where and $fld>=$min and $fld<=$max $sql";
		$rs=exec_qry($conn,$sql);
		if($row=fetch_row($rs)){
			$critthismonth+=$row[0];
		}else{
			$critthismonth=$critical;
		}
		$where="YEARWEEK(dt) = YEARWEEK(CURRENT_DATE)";
		$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
		$sql="select count(host) from core_status_sla where $where and $fld>=$min and $fld<=$max $sql";
		$rs=exec_qry($conn,$sql);
		if($row=fetch_row($rs)){
			$critthisweek+=$row[0];
		}else{
			$critthisweek=$critical;
		}
		$where="YEARWEEK(dt) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK)";
		$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
		$sql="select count(host) from core_status_sla where $where and $fld>=$min and $fld<=$max $sql";
		$rs=exec_qry($conn,$sql);
		if($row=fetch_row($rs)){
			$critlastweek+=$row[0];
		}
	}
	if($svr=="major"){
		$where="YEARWEEK(dt) = YEARWEEK(CURRENT_DATE)";
		$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
		$sql="select count(host) from core_status_sla where $where and $fld>=$min and $fld<=$max $sql";
		$rs=exec_qry($conn,$sql);
		if($row=fetch_row($rs)){
			$majorthisweek+=$row[0];
		}else{
			$majorthisweek=$major;
		}
		$where="YEARWEEK(dt) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK)";
		$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
		$sql="select count(host) from core_status_sla where $where and $fld>=$min and $fld<=$max $sql";
		$rs=exec_qry($conn,$sql);
		if($row=fetch_row($rs)){
			$majorlastweek+=$row[0];
		}
	}
	if($svr=="minor"){
		$where="YEARWEEK(dt) = YEARWEEK(CURRENT_DATE)";
		$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
		$sql="select count(host) from core_status_sla where $where and $fld>=$min and $fld<=$max $sql";
		$rs=exec_qry($conn,$sql);
		if($row=fetch_row($rs)){
			$minorthisweek+=$row[0];
		}else{
			$minorthisweek=$minor;
		}
		$where="YEARWEEK(dt) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK)";
		$sql=$net==""?"":" and host in (select host from core_node where net='$net')";
		$sql="select count(host) from core_status_sla where $where and $fld>=$min and $fld<=$max $sql";
		$rs=exec_qry($conn,$sql);
		if($row=fetch_row($rs)){
			$minorlastweek+=$row[0];
		}
	}
}

disconnect($conn);

//echo json_encode(($yearweeks));

$critcompare=compare($critlastmonth,$critthismonth,"vs previous month");
$critsign=compare_class($critlastmonth,$critthismonth,"text-success","fa fa-arrow-circle-o-up text-danger","fa fa-arrow-circle-o-down text-success");

$critcompareweek=compare($critlastweek,$critthisweek,"</span> vs last week");
$majorcompareweek=compare($majorlastweek,$majorthisweek,"</span> vs last week");
$minorcompareweek=compare($minorlastweek,$minorthisweek,"</span> vs last week");

$critsignweek=compare_class($critlastweek,$critthisweek,'<span class="text-success mr-1"> ','<span class="text-danger mr-1"><i class="fe fe-arrow-up ml-1"></i>','<span class="text-success mr-1"><i class="fe fe-arrow-down ml-1"></i>');
$majorsignweek=compare_class($majorlastweek,$majorthisweek,'<span class="text-success mr-1"> ','<span class="text-danger mr-1"><i class="fe fe-arrow-up ml-1"></i>','<span class="text-success mr-1"><i class="fe fe-arrow-down ml-1"></i>');
$minorsignweek=compare_class($minorlastweek,$minorthisweek,'<span class="text-success mr-1"> ','<span class="text-danger mr-1"><i class="fe fe-arrow-up ml-1"></i>','<span class="text-success mr-1"><i class="fe fe-arrow-down ml-1"></i>');

//$msgs = array("major"=>$major, "minor"=>$minor, "critical"=>$critical);
//echo json_encode(array('code'=>"200",'ttl'=>"OK",'msgs'=>$msgs));
?>
	<div class="col-md-4 text-center mb-4 mb-md-0">
		<p class="data-attributes mb-0">
			<span class="donut" data-peity='{ "fill": ["#fb1c52", "#e5e9f2"]}'><?php echo $critical?>/<?php echo $total?></span>
		</p>
		<h4 class=" mb-0 font-weight-semibold"><?php echo $critical?></h4>
		<p class="mb-0 text-muted">Critical</p>
	</div>
	<div class="col-md-4 text-center mb-4 mb-md-0">
		<p class="data-attributes mb-0">
			<span class="donut" data-peity='{ "fill": ["#f7be2d", "#e5e9f2"]}'><?php echo $major?>/<?php echo $total?></span>
		</p>
		<h4 class=" mb-0 font-weight-semibold"><?php echo $major?></h4>
		<p class="mb-0 text-muted">Major</p>
	</div>
	<div class="col-md-4 text-center">
		<p class="data-attributes mb-0">
			<span class="donut" data-peity='{ "fill": ["#27af06", "#e5e9f2"]}'><?php echo $minor?>/<?php echo $total?></span>
		</p>
		<h4 class=" mb-0 font-weight-semibold"><?php echo $minor?></h4>
		<p class="mb-0 text-muted">Minor</p>
	</div>

<script>
 $('span.donut').peity('donut',{
        width: '50',
        height: '50'
    });
$("#critthismonth").html('<?php echo $critthismonth?>');
$("#critcompare").html('<?php echo $critcompare?>');
$(".critsign").addClass("<?php echo $critsign?>");

$("#critthisweek").html('<?php echo $critthisweek?>');
$("#majorthisweek").html('<?php echo $majorthisweek?>');
$("#minorthisweek").html('<?php echo $minorthisweek?>');

$("#critlastweek").html('<?php echo $critsignweek.$critcompareweek?>');
$("#majorlastweek").html('<?php echo $majorsignweek.$majorcompareweek?>');
$("#minorlastweek").html('<?php echo $minorsignweek.$minorcompareweek?>');

/* chartjs (#sales) */
	var myCanvas = document.getElementById("salesx");
	
	var myCanvasContext = myCanvas.getContext("2d");
	var gradientStroke = myCanvasContext.createLinearGradient(0, 80, 0, 280);
	gradientStroke.addColorStop(0, 'rgba(74, 50, 212, 0.8)');
	gradientStroke.addColorStop(1, 'rgba(74, 50, 212, 0.09) ');
    var myChart = new Chart( myCanvas, {
		type: 'line',
		data: {
            labels: <?php echo json_encode(array_keys($yearweeks))?>,//["2000",
                    // "2001","2002", "2003", "2004","2005","2006","2007", "2008","2009","2010","2011","2012","2013","2014","2015","2016","2017","2018","2019", ],
            type: 'line',
            datasets: [ {
				label: 'Weekly Alert',
				data: <?php echo json_encode(array_values($yearweeks))?>,//[ 19,  43, 45, 60, 54, 41, 45, 26, 45, 21, 45, 64, 35, 65, 34, 34, 43, 46, 24, 23],
				backgroundColor: gradientStroke,
				borderColor: '#4a32d4',
				pointBackgroundColor:'#fff',
				pointHoverBackgroundColor:gradientStroke,
				pointBorderColor :'#007adf',
				pointHoverBorderColor :gradientStroke,
				pointBorderWidth :0,
				pointRadius :0,
				pointHoverRadius :0,
				lineTension: 0.2,
				 borderWidth: 2,
                    fill: 'origin'
            }, ]
        },
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#000',
				bodyFontColor: '#000',
				backgroundColor: '#fff',
				cornerRadius: 3,
				intersect: false,
			},
			 stepsize: 200,
                min: 0,
                max: 400,
			legend: {
				display: false,
				labels: {
					usePointStyle: false,
				},
			},
			scales: {
				xAxes: [{
					
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					ticks: {
                            fontColor: '#b0bac9',
                            autoSkip: true,
                            maxTicksLimit: 9,
                            maxRotation: 0,
                            labelOffset: 10
                        },
					scaleLabel: {
						display: false,
						labelString: 'Week',
						fontColor: 'transparent'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "#b0bac9",
					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'sales',
						fontColor: 'transparent'
					}
				}]
			},
			title: {
				display: false,
				text: 'Normal Legend'
			}
		}
	});
	/* chartjs (#sales) closed */
</script>
