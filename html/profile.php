<?php 
include "inc.common.php";
include "inc.session.php";

$page_icon="fa fa-home";
$page_title="My Profile";
$modal_title="My Profile";
$menu="profile";

$breadcrumb="Profile/$page_title";

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
							<div class="col-md-6">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Personal Data</div>
										<div class="card-options ">
											
										</div>
									</div>
									<div class="card-body">
										<form id="myf" class="form-horizontal">
								<!--hidden-->
								<input type="hidden" name="rowid" id="rowid" value="0">
								<input type="hidden" name="mnu" value="<?php echo $menu?>">
								<input type="hidden" name="sv" value="UPD" />
								<input type="hidden" name="cols" value="uname" />
								<input type="hidden" name="tname" value="core_user" />
										
										  <div class="row">
											<div class="form-group col-md-6">
												<label>ID</label>
												<input type="text" readonly id="uid" name="uid" placeholder="..." class="form-control">
											</div>
											<div class="form-group col-md-6">
												<label>Name</label>
												<input type="text" id="uname" name="uname" placeholder="..." class="form-control">
											</div>
										  </div>
										  <div class="row">
											<div class="form-group col-md-6">
												<label>Group</label>
												<input readonly type="text" id="ugrp" name="ugrp" placeholder="..." class="form-control">
											</div>
											<div class="form-group col-md-6">
												<label>Picture</label>
												<input type="file" id="favatar" name="favatar" accept="image/*" placeholder="..." class="form-control">
											</div>
										  </div>
										</form>
									</div>
									<div class="card-footer">
										<div class="pull-right">
											<button type="button" class="btn btn-warning" onclick="resetAvatar();">Reset Picture</button>
											<button type="button" class="btn btn-success" onclick="saveData();">Save</button>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Reset Password</div>
										<div class="card-options ">
											
										</div>
									</div>
									<div class="card-body">
										<form id="myfx" class="form-horizontal">
								<!--hidden-->
								<input type="hidden" name="rowid" id="rowid" value="0">
								<input type="hidden" name="mnu" value="passwd">
								<input type="hidden" name="sv" value="UPD" />
								<input type="hidden" name="cols" value="" />
								<input type="hidden" name="tname" value="" />
										
											<div class="form-group">
												<label>Old Password</label>
												<input type="password" id="op" name="op" placeholder="..." class="form-control">
											</div>
											<div class="row">
												<div class="form-group col-md-6">
													<label>New Password</label>
													<input type="password" id="np" name="np" placeholder="..." class="form-control">
												</div>
												<div class="form-group col-md-6">
													<label>Retype New Password</label>
													<input type="password" id="rp" name="rp" placeholder="..." class="form-control">
												</div>
											</div>
										</form>
									</div>
									<div class="card-footer">
										<div class="pull-right">
											<button type="button" class="btn btn-success" onclick="if($('#myfx').valid()){sendDataFile('UPD','#myfx');}">Save</button>
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
	
	jvalidatex = $("#myfx").validate({
    ignore: ":hidden:not(.selectpicker)",
	rules :{
        "op" : {
			required : true
		},
		"np" : {
			required : true
		},
		"rp" : {
			required : true,
			equalTo : "#np"
		}
    }});
	
	openForm('profile','<?php echo $s_ID?>');
})
</script>

  </body>
</html>