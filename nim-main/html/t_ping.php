<?php 
include "inc.common.php";
include "inc.session.php";

$page_icon="fa fa-home";
$page_title="Ping";
$modal_title="Ping";
$card_title="Ping Test";

$menu="tping";

$breadcrumb="Tools/$page_title";

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
									
						<div class="row">
							<div class="col-md-4">
								<div class="card">
									<div class="card-header">
										<div class="card-title"><?php echo $card_title ?></div>
										<div class="card-options ">
											
										</div>
									</div>
									<div class="card-body">
										<form id="myf" class="form-horizontal">
								<!--hidden-->
								<input type="hidden" name="mnu" value="<?php echo $menu?>">
										<div class="row">
											<div class="form-group col-md-9">
												<label>Host</label>
												<input type="text" id="host" name="host" placeholder="..." class="form-control">
											</div>
											<div class="form-group col-md-3">
												<label>Count</label>
												<input type="text" id="cnt" name="cnt" placeholder="..." class="form-control">
											</div>
										</div>
										</form>
									</div>
									<div class="card-footer">
										<div class="pull-right">
											<button type="button" class="btn btn-success" onclick="execute();">Execute</button>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Result</div>
										<div class="card-options ">
											
										</div>
									</div>
									<div class="card-body">
										<div class="dimmer active ldr">
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
										<div class="hasil">
										
										</div>
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
var jvalidate;
$(document).ready(function(){
	page_ready();
	$(".ldr").hide();
	
	jvalidate = $("#myf").validate({
    ignore: ":hidden:not(.selectpicker)",
	rules :{
        "host" : {
			required : true
		},
		"cnt" : {
			required : true,
			digits : true
		}
    }});
	
})

function execute(){
	if($("#myf").valid()){
		exec_command('ping',$('#host').val(),$('#cnt').val());
	}
}
</script>

  </body>
</html>