<?php
$redirect=false;

include "inc.common.php";
include "inc.session.php";
include "inc.db.php";

$conn=connect();

$slas=array();

//sla today
$sql="select dt,round(sum(uptime)/sum(uptime+downtime)*100,2) as sla from core_status_sla where dt >= (CURRENT_DATE - INTERVAL 1 MONTH) group by dt order by dt";
$rs=exec_qry($conn,$sql);
$recs=fetch_alla($rs);
for($i=0;$i<count($recs);$i++){
	$rec=$recs[$i];
	$slas[$rec['dt']]=$rec['sla']==null?0:$rec['sla'];
}

disconnect($conn);
?>
<script>
/* chartjs (#sales) */
	var myCanvas = document.getElementById("sales");
	
	var myCanvasContext = myCanvas.getContext("2d");
	var gradientStroke = myCanvasContext.createLinearGradient(0, 80, 0, 280);
	gradientStroke.addColorStop(0, 'rgba(74, 50, 212, 0.8)');
	gradientStroke.addColorStop(1, 'rgba(74, 50, 212, 0.09) ');
    var myChart = new Chart( myCanvas, {
		type: 'line',
		data: {
            labels: <?php echo json_encode(array_keys($slas))?>, //["2000",
                     //"2001","2002", "2003", "2004","2005","2006","2007", "2008","2009","2010","2011","2012","2013","2014","2015","2016","2017","2018","2019", ],
            type: 'line',
            datasets: [ {
				label: 'Overall SLA Daily',
				data: <?php echo json_encode(array_values($slas))?>,//[ 19,  43, 45, 60, 54, 41, 45, 26, 45, 21, 45, 64, 35, 65, 34, 34, 43, 46, 24, 23],
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