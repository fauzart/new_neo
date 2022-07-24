<?php 
include "inc.common.php";
include "inc.session.php";

$page_icon="fa fa-home";
$page_title="Summary";
$modal_title="Title of Modal";
$menu="home";

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
										<div class="">Total Device</div>
										<div class="h3 mt-2 mb-2 dtot">0 <span class="text-success fs-13 ml-2">(0%)</span></div>
									</div>
									<div class="feature">
										<a href="n_device<?php echo $ext?>">
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
										<div class="">Device Up</div>
										<div class="h3 mt-2 mb-2 don">0 <span class="text-success fs-13 ml-2">(0%)</span></div>
									</div>
									<div class="feature">
										<a href="n_device<?php echo $ext?>?status=1">
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
										<div class="">Device Down</div>
										<div class="h3 mt-2 mb-2 doff">0 <span class="text-success fs-13 ml-2">(0%)</span></div>
									</div>
									<div class="feature">
										<a href="n_device<?php echo $ext?>?status=0">
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
			
		
			<!--Row-->
			<div class="row">
				<div class="col-xl-8 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Regional Device</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xl-8 col-lg-8 col-md-12">
									<div class="overflow-hidden">
										<div id="world-map-markers" class="worldh h-276" ></div>
									</div>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-12">
									<h3 class="font-weight-semibold"><span class="tdev">0</span> <span class="text-muted fs-12">all device</span></h3>
									<div class="table-responsive text-muted" style="max-height: 260px;">
										<table class="table text-nowrap border-0 mb-0 ">
											<tbody id="isi-propinsi">
											</tbody>
										</table>
										<div class="dimmer active ldr-propinsi">
											<div class="sk-cube-grid">
												<div class="sk-cube sk-cube1"></div>
												<div class="sk-cube sk-cube2"></div>
												<div class="sk-cube sk-cube3"></div>
												<div class="sk-cube sk-cube4"></div>
												<div class="sk-cube sk-cube5"></div>
												<div class="sk-cube sk-cube6"></div>
												<div class="sk-cube sk-cube7"></div>
												<div class="sk-cube sk-cube8"></div>
												<div class="sk-cube sk-cube9"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-12 col-lg-12">
					<div class="card overflow-hidden">
						<div class="card-header">
							<h3 class="card-title">Slowest RTT</h3>
						</div>
						<div class="card-body p-0">
							<div id="isi-speed"></div>
							<div class="dimmer active ldr-speed">
								<div class="sk-cube-grid">
									<div class="sk-cube sk-cube1"></div>
									<div class="sk-cube sk-cube2"></div>
									<div class="sk-cube sk-cube3"></div>
									<div class="sk-cube sk-cube4"></div>
									<div class="sk-cube sk-cube5"></div>
									<div class="sk-cube sk-cube6"></div>
									<div class="sk-cube sk-cube7"></div>
									<div class="sk-cube sk-cube8"></div>
									<div class="sk-cube sk-cube9"></div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- row closed -->
			
			
			<!--Row-->
			<div class="row">
				<div class="col-xl-5 col-md-12 col-lg-5">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title mb-0">Current Alert</h3>
						</div>
						<div class="card-body">
							<div class="row" id="isi-alert"></div>
							<div class="dimmer active ldr-alert">
								<div class="sk-cube-grid">
									<div class="sk-cube sk-cube1"></div>
									<div class="sk-cube sk-cube2"></div>
									<div class="sk-cube sk-cube3"></div>
									<div class="sk-cube sk-cube4"></div>
									<div class="sk-cube sk-cube5"></div>
									<div class="sk-cube sk-cube6"></div>
									<div class="sk-cube sk-cube7"></div>
									<div class="sk-cube sk-cube8"></div>
									<div class="sk-cube sk-cube9"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="">
								<h5>Total Critical</h5>
							</div>
							<h2 class="mb-2 font-weight-semibold"><span id="critthismonth">0</span><span class="sparkline_bar31 float-right"></span></h2>
							<div class="text-muted mb-0">
								<i class="critsign"></i>
								<span id="critcompare">-</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-7 col-md-12 col-lg-7">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Weekly Alert</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-12 mb-5">
									<p class=" mb-0 "> Critical</p>
									<h2 class="mb-0 font-weight-semibold"><span id="critthisweek">0</span><span id="critlastweek" class="fs-12 text-muted"><span class="text-success mr-1"> 0%</span>last week</span></h2>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-12 mb-5">
									<p class=" mb-0 "> Major </p>
									<h2 class="mb-0 font-weight-semibold"><span id="majorthisweek">0</span><span id="majorlastweek" class="fs-12 text-muted"><span class="text-success mr-1"> 0%</span>last week</span></h2>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-12 mb-5">
									<p class=" mb-0 "> Minor</p>
									<h2 class="mb-0 font-weight-semibold"><span id="minorthisweek">0</span><span id="minorlastweek" class="fs-12 text-muted"><span class="text-success mr-1"> 0%</span>last week</span></h2>
								</div>
							</div>
							<div class="chart-wrapper">
								<canvas id="salesx" class=" chartjs-render-monitor chart-dropshadow2 h-184"></canvas>
							</div>
							<div class="dimmer active ldr-alert">
								<div class="sk-cube-grid">
									<div class="sk-cube sk-cube1"></div>
									<div class="sk-cube sk-cube2"></div>
									<div class="sk-cube sk-cube3"></div>
									<div class="sk-cube sk-cube4"></div>
									<div class="sk-cube sk-cube5"></div>
									<div class="sk-cube sk-cube6"></div>
									<div class="sk-cube sk-cube7"></div>
									<div class="sk-cube sk-cube8"></div>
									<div class="sk-cube sk-cube9"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--End row-->
			
			
			<!--Row-->
			<div class="row">
				<div class="col-xl-8 col-md-12 col-lg-7">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">SLA</h3>
						</div>
						<div class="card-body overflow-hidden">
							<!--div id="flotContainer2" class="chart-style"></div-->
							<canvas id="sales" class=" chartjs-render-monitor chart-dropshadow2 h-184"></canvas>
							<div class="row" id="isi-sla"></div>
							<div class="dimmer active ldr-sla">
								<div class="sk-cube-grid">
									<div class="sk-cube sk-cube1"></div>
									<div class="sk-cube sk-cube2"></div>
									<div class="sk-cube sk-cube3"></div>
									<div class="sk-cube sk-cube4"></div>
									<div class="sk-cube sk-cube5"></div>
									<div class="sk-cube sk-cube6"></div>
									<div class="sk-cube sk-cube7"></div>
									<div class="sk-cube sk-cube8"></div>
									<div class="sk-cube sk-cube9"></div>
								</div>
							</div>
						</div>
						<div class="card-footer p-5">
							<div class="row ">
								<div class="col-xl-4 col-lg-4 col-md-12">
									<h6 class=" mb-0 ">OverAll Device</h6>
									<h2 class="mb-0"><span class="font-weight-semibold sla_all">0</span>%<span class="fs-12 text-muted sla_all_perc"><span class="text-success mr-1"> 0%</span> vs yesterday</span></h2>
									<div class="progress progress-xs mt-3 h-1 sla_all_progress">
										<div class="progress-bar bg-primary w-0 " role="progressbar"></div>
									</div>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-12  mt-5 mt-xl-0 mt-lg-0">
									<h6 class=" mb-0 ">Online Device</h6>
									<h2 class="mb-0"><span class="font-weight-semibold sla_on">0</span>%<span class="fs-12 text-muted sla_on_perc"><span class="text-success mr-1"> 0%</span> vs yesterday</span></h2>
									<div class="progress progress-xs mt-3 h-1 sla_on_progress">
										<div class="progress-bar bg-success w-0 " role="progressbar"></div>
									</div>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-12  mt-5 mt-xl-0 mt-lg-0">
									<h6 class=" mb-0 ">Offline Device</h6>
									<h2 class="mb-0"><span class="font-weight-semibold sla_off">0</span><span class="fs-12 text-muted sla_off_perc"><span class="text-success mr-1"> 0%</span> vs yesterday</span></h2>
									<div class="progress progress-xs mt-3 h-1 sla_off_progress">
										<div class="progress-bar bg-danger w-0 " role="progressbar"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-12 col-lg-5">
					<div class="card">
						<div class="card-header pt-2 pb-0 border-bottom-0">
							<h3 class="card-title">Best Device Performance</h3>
							<div class="card-options">
								<div class="feature text-center ">
									<i class="fe fe-trending-up border-radius-4 primary mt-3 mr-3 text-white fa-stack services "></i>
								</div>
							</div>
						</div>
						<div class="card-body pt-0">
							<h2 class="mb-1 number-font"><span class="counter font-weight-semibold sla_max">0%</span></h2>
							<div class="d-flex">
								<small class="mb-0 number-font1 sla_max_perc"><span class="text-success">0%</span></small>
								<small class="text-muted ml-2 fs-12"> vs Yesterday</small>
							</div>
							<div class="row mt-3 dash1">
								<div class="col  border-right">
									<h6 class="font-weight-500 number-font1 mb-0 sla_max_w">0%</h6>
									<span class="text-muted">Weekly</span>
								</div>
								<div class="col  border-right">
									<h6 class="font-weight-500 number-font1 mb-0 sla_max_m">0%</h6>
									<span class="text-muted">Monthly</span>
								</div>
								<div class="col ">
									<p class="font-weight-500 number-font1 mb-0 sla_max_y">0%</p>
									<span class="text-muted">Yearly</span>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header pt-2 pb-0 border-bottom-0">
							<h3 class="card-title">Worst Device Performance</h3>
							<div class="card-options">
								<div class="feature text-center ">
									<i class="fe fe-trending-down border-radius-4 danger mt-3 mr-3 text-white fa-stack services "></i>
								</div>
							</div>
						</div>
						<div class="card-body pt-0">
							<h2 class="mb-1 number-font"><span class="counter font-weight-semibold sla_min">0%</span></h2>
							<div class="d-flex">
								<small class="mb-0 number-font1 sla_min_perc"><span class="text-success">0%</span></small>
								<small class="text-muted ml-2 fs-12"> vs Yesterday</small>
							</div>
							<div class="row mt-3 dash1">
								<div class="col  border-right">
									<h6 class="font-weight-500 number-font1 mb-0 sla_min_w">0%</h6>
									<span class="text-muted">Weekly</span>
								</div>
								<div class="col  border-right">
									<h6 class="font-weight-500 number-font1 mb-0 sla_min_m">0%</h6>
									<span class="text-muted">Monthly</span>
								</div>
								<div class="col ">
									<p class="font-weight-500 number-font1 mb-0 sla_min_y">0%</p>
									<span class="text-muted">Yearly</span>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			<!--End Row-->

		</div>
	</div><!-- end app-content-->
				
<?php 
include "inc.foot.php";
include "inc.js.php";
?>
		<!-- ECharts js-->
		<script src="aronox/assets/plugins/echarts/echarts.js"></script>
		<!--Morris Charts js -->
		<script src="aronox/assets/plugins/morris/raphael-min.js"></script>
		<script src="aronox/assets/plugins/morris/morris.js"></script>
		<!-- Flot Charts js-->
		<script src="aronox/assets/plugins/flot/jquery.flot.js"></script>
		<script src="aronox/assets/plugins/flot/jquery.flot.fillbetween.js"></script>
		<script src="aronox/assets/plugins/flot/jquery.flot.pie.js"></script>
		<!-- Vector js -->
		<script src="aronox/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
        <script src="aronox/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		<script src="aronox/assets/js/vectormap.js"></script>
		
		<!-- Peitychart init demo js-->
		<script src="aronox/assets/plugins/peitychart/peitychart.init.js"></script>
		
		<!-- Apexchart js-->
		<script src="aronox/assets/js/apexcharts.js"></script>
		
		<!-- Index js-->
		<!--script src="aronox/assets/js/index4.js"></script>
		<script src="aronox/assets/js/index1.js"></script-->
<script>
$(document).ready(function(){
	page_ready();
	displayClock();
	
	getData('home1','home-onoff');
	get_content("home-province<?php echo $ext?>",{},".ldr-propinsi","#isi-propinsi");
	get_content("home-speed<?php echo $ext?>",{},".ldr-speed","#isi-speed");
	get_content("home-alert<?php echo $ext?>",{},".ldr-alert","#isi-alert");
	getData('sla','home-sla');
	get_content("home-sla-chart<?php echo $ext?>",{},".ldr-sla","#isi-sla");
});

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

</script>

  </body>
</html>