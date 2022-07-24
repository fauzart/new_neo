<?php 
$redirect=false;
$cleartext=true;

include "inc.common.php";
include "inc.session.php";

include "lib_inc.db.php";

$h=get("h");
$idx=get("idx");

$page_icon="fa fa-home";
$page_title="Host : $h";
$modal_title="My Profile";
$menu="libdevice";

$breadcrumb="Plugins/SNMP/$page_title";

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
										<div class="card-title">Interfaces</div>
										<div class="card-options ">
											<a href="#" title="Expand/Collapse" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
							
										</div>
									</div>
									<div class="card-body">
										<div class="dimmer active ldr-inter">
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
										<div id="isi-inter"></div>
									
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Health</div>
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
	
	get_content("lib_device_info<?php echo $ext?>",{idx:"<?php echo $idx?>"},".ldr-info","#isi-info");
	get_content("lib_device_inter<?php echo $ext?>",{h:"<?php echo $h?>",idx:"<?php echo $idx?>"},".ldr-inter","#isi-inter");
	get_content("lib_device_perf<?php echo $ext?>",{h:"<?php echo $h?>",idx:"<?php echo $idx?>"},".ldr-perf","#isi-perf");
	
})
</script>

  </body>
</html>