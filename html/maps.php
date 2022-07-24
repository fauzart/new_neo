<?php 
include "inc.common.php";
include "inc.session.php";

$page_icon="fa fa-home";
$page_title="Locations";
$modal_title="Title of Modal";
$menu="maps";

$breadcrumb="Overview/$page_title";

include "inc.head.php";
include "inc.menutop.php";
?>

	<div class="app-content page-body">
		<div class="container">

			<!--Page header-->
			<div class="page-header">
				<div class="page-leftheader">
					<h4 class="page-title"><?php echo $page_title ?></h4>
					<ol class="breadcrumb pl-0">
						<?php echo breadcrumb($breadcrumb)?>
					</ol>
				</div>

			</div>
			<!--End Page header-->
			
		
			<!-- ROW OPEN -->
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card">
						<div class="card-body">
							<div class="card-order">
								<div class="row">
									<div class="col">
										<div class="">Total Locations</div>
										<div class="h3 mt-2 mb-2 dtot">0 <span class="text-success fs-13 ml-2">(0%)</span></div>
									</div>
									<div class="feature">
										<a href="n_location<?php echo $ext?>">
											<i class="si si-screen-desktop primary feature-icon bg-secondary"></i>
										</a>
									</div>
								</div>
								<!--
								<p class="mb-0 text-muted">Monthly users</p>
								-->
							</div>
						</div>
					</div>
				</div><!-- COL END -->
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card ">
						<div class="card-body">
							<div class="card-order">
								<div class="row">
									<div class="col">
										<div class="">Locations Up</div>
										<div class="h3 mt-2 mb-2 don">0 <span class="text-success fs-13 ml-2">(0%)</span></div>
									</div>
									<div class="feature">
										<a href="n_location<?php echo $ext?>?status=1">
											<i class="si si-arrow-up-circle success feature-icon bg-success"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- COL END -->
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card">
						<div class="card-body">
							<div class="card-order">
								<div class="row">
									<div class="col">
										<div class="">Locations Down</div>
										<div class="h3 mt-2 mb-2 doff">0 <span class="text-success fs-13 ml-2">(0%)</span></div>
									</div>
									<div class="feature">
										<a href="n_location<?php echo $ext?>?status=0">
											<i class="si si-arrow-down-circle danger feature-icon bg-danger"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- COL END -->
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card ">
						<div class="card-body">
							<div class="card-order">
								<div class="row">
									<div class="col">
										<div id="tgl" class="">January 1, 1970</div>
										<div class="h3 mt-2 mb-2"><b id="jam">00:00:00</b><span id="zone" class="text-success fs-13 ml-2">UTC</span></div>
									</div>
									<div class="feature">
										<i class="si si-clock secondary feature-icon bg-primary"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- COL END -->
			</div>
			<!-- End Row -->			

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div id="map" style="height:450px; z-index: 1;"></div>
						</div>
					</div>
				</div>
			</div>
		
		</div>
	</div><!-- end app-content-->
				
<?php 
include "inc.foot.php";
include "inc.js.php";
?>
<script>
markerClickFunction = function(id) {
		return function(e) {
			e.cancelBubble = true;
		e.returnValue = false;
		if (e.stopPropagation) {
		  e.stopPropagation();
		  e.preventDefault();
		}
		//if(id=="0"){
			location.href="n_device"+ext+"?loc="+id;
		//}else{
		//	location.href="device.php?id="+id;
		//	}
	}}

$(document).ready(function(){
	page_ready();
	displayClock();
	
	getData('onoff','maps-onoff');
	widget_map();
	
});


var map;
var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

function displayClock(){
	var d=new Date();
	var zone=d.toString().match(/([\+-][0-9]+)\s/)[1];
	$("#zone").text('('+zone+')');
	var tgl=months[d.getMonth()]+" "+d.getDate()+", "+d.getFullYear();
	$("#tgl").text(tgl);
	var jam=d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();
	$("#jam").text(jam);
		
	setTimeout(displayClock,1000);
}

function widget_map(){
	map = L.map('map').setView([-2, 118], 5);

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);
	
	//L.geoJSON(indonesia).addTo(map);
	get_loc();
}

function get_loc(){
	$.ajax({
		type: 'POST',
		url: 'dataget'+ext,
		data: {q:'map',id:0},
		success: function(data){
			var json = JSON.parse(data);
			if(json['code']=='200'){
				draw_map(json['msgs']);
			}else{
				log(json['msgs']);
			}
		},
		error: function(xhr){
			log('Please check your connection'+xhr);
		}
	});
}

function draw_map(data){
	var markers = L.markerClusterGroup();
		
		for (var i = 0; i < data.length; i++) {
			var a = data[i];
			var title = a['name'];
			var color = a['onoff']>0?"green":"red";
			var icon = L.AwesomeMarkers.icon({icon: 'server', prefix: 'fa', markerColor: color});
			
			var marker = L.marker(new L.LatLng(a['lat'], a['lng']), { title: title, icon: icon });
			
			var fn=markerClickFunction(a['locid']);
			marker.on('click', fn);
			
			markers.addLayer(marker);
		}

		map.addLayer(markers);
}

</script>

  </body>
</html>