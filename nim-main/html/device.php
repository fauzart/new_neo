<?php 
$redirect=false;
$cleartext=true;

include "inc.common.php";
include "inc.session.php";

include "inc.db.php";

$h=get("h");

$page_icon="fa fa-home";
$page_title="Device : $h";
$modal_title="My Profile";
$menu="device";

$breadcrumb="Nodes/Devices/$page_title";

include "inc.head.php";
//include "inc.menutop.php";
?>

				<div class="page-body">
					<div class="container" style="max-width:95%; width: 95%;">

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
									
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Info</div>
										<div class="card-options ">
											<a href="#" title="Expand/Collapse" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
							
										</div>
									</div>
									<div class="card-body">
										<div class="dimmer active ldr-info">
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
										<div id="isi-info"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Status</div>
										<div class="card-options ">
											<a href="#" title="Expand/Collapse" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
							
										</div>
									</div>
									<div class="card-body">
										<div class="dimmer active ldr-status">
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
										<div id="isi-status"></div>
										<div class="panel panel-primary">
											<div class=" tab-menu-heading">
												<div class="tabs-menu1 ">
													<!-- Tabs -->
													<ul class="nav panel-tabs">
														<li><a href="#tab6" data-toggle="tab" class="">Log</a></li>
														<li><a href="#tab7" data-toggle="tab" class="">Trace</a></li>
													</ul>
												</div>
											</div>
											<div class="panel-body tabs-menu-body">
												<div class="tab-content">
													<div class="tab-pane" id="tab6">
														<pre id="isi-tab6"></pre>
														<span class="ldr-log">Loading...</span>
													</div>
													<div class="tab-pane" id="tab7">
														<pre id="isi-tab7"></pre>
														<span class="ldr-trace">Loading...</span>
													</div>
												</div>
											</div>
										</div>
									
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Performance</div>
										<div class="card-options ">
											<a href="#" title="Expand/Collapse" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
							
										</div>
									</div>
									<div class="card-body">
										<div class="dimmer active ldr-perf">
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
										<div id="isi-perf"></div>
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
var jvalidate,jvalidatex;
$(document).ready(function(){
	page_ready();
	
	jvalidate = $("#myf").validate({
    ignore: ":hidden:not(.selectpicker)",
	rules :{
        "uname" : {
			required : true
		}
    }});
	
	get_content("device_info<?php echo $ext?>",{h:"<?php echo $h?>"},".ldr-info","#isi-info");
	get_content("device_status<?php echo $ext?>",{h:"<?php echo $h?>"},".ldr-status","#isi-status");
	
	get_content("/cgi-bin/log.sh",{h:"<?php echo $h?>",f:"log"},".ldr-log","#isi-tab6","GET");
	get_content("/cgi-bin/log.sh",{h:"<?php echo $h?>",f:"trace"},".ldr-trace","#isi-tab7","GET");
	
	get_content("device_perf<?php echo $ext?>",{h:"<?php echo $h?>"},".ldr-perf","#isi-perf");
	
})
</script>

  </body>
</html>