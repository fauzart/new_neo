<?php 
$restrict_lvl=array("0","1");

include "inc.common.php";
include "inc.session.php";

$page_icon="fa fa-table";
$page_title="Background Job";
$modal_title="Background Job";
$card_title="$page_title";

$menu="mbg";

$breadcrumb="Setup/$page_title";

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
			<!--div class="page-rightheader">
				<a href="#" class="btn btn-primary" onclick="" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Create</a>
			</div-->
		</div>
		<!--End Page header-->
		
				<div class="card">
					<div class="card-header">
						<div class="card-title"><?php echo $card_title ?></div>
						<div class="card-options ">
							<!--a href="#" title="Batch" class=""><i class="fe fe-upload"></i></a--
							<a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#myModal" title="Add" class=""><i class="fe fe-plus"></i></a-->
							<a href="#" title="Refresh" onclick="reloadtbl();"><i class="fe fe-refresh-cw"></i></a>
							<a href="#" title="Expand/Collapse" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
							<!--a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a-->
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="mytbl" class="table table-striped table-bordered w-100">
								<thead>
									<tr>
										<th>Name</th>
										<th>Started At</th>
										<th>Finished At</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>

	</div>
</div><!-- end app-content-->

<!-- Modal-->
<div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left modal_form">
  <div role="document" class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header"><strong id="exampleModalLabel" class="modal-title"><?php echo $modal_title?></strong>
		<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">x</span></button>
	  </div>
	  <div class="modal-body">
		<!--p>Lorem ipsum dolor sit amet consectetur.</p-->
		<form id="myf" class="form-horizontal">
<!--hidden-->
<input type="hidden" name="rowid" id="rowid" value="0">
<input type="hidden" name="mnu" value="<?php echo $menu?>">
<input type="hidden" id="sv" name="sv" />
<input type="hidden" name="cols" value="startnow" />
<input type="hidden" name="tname" value="core_bgjob" />
<input type="hidden" id="running" />
<input type="hidden" name="startnow" id="startnow">
					
		  <div class="row">
			<div class="form-group col-md-6">
				<label>Name</label>
				<input type="text" readonly id="name" name="name" placeholder="..." class="form-control">
			</div>
			<div class="form-group col-md-6">
				<label>Status</label>
				<input type="text" readonly id="status" name="status" placeholder="..." class="form-control">
			</div>
			
		  </div>
		  <div class="row">
			<div class="form-group col-md-6">
				<label>Started At</label>
				<input type="text" readonly id="startedat" name="startedat" placeholder="..." class="form-control">
			</div>
			<div class="form-group col-md-6">
				<label>Finished At</label>
				<input type="text" readonly id="finishedat" name="finishedat" placeholder="..." class="form-control">
			</div>
		  </div>
		  <!--div class="row">
			<div class="form-group col-md-6">
				<label>&nbsp;</label>
				<label class="custom-control custom-checkbox">
					<input type="checkbox" name="start" id="start" value="1" class="custom-control-input">
					<span class="custom-control-label" onclick="toggle_checkbox('#start')"> Start Now</span>
				</label>
			</div>
		  </div-->
		</form>
	  </div>
	  <div class="modal-footer">
	    <!--button type="button" class="btn btn-danger" id="bdel"  onclick="confirmDelete();">Delete</button-->
		<button type="button" class="btn btn-success" onclick="checkAndSave();">Start</button>
		<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
		
	  </div>
	</div>
  </div>
</div>

<?php 
include "inc.foot.php";
include "inc.js.php";

$tname="core_bgjob";
$cols="name,startedat,finishedat,if(running='1','Running',if(startnow='1','Starting','Stopped')) as status,rowid";
$csrc="name";

?>

<script>
var mytbl, jvalidate;
$(document).ready(function(){
	page_ready();
	mytbl = $("#mytbl").DataTable({
		serverSide: true,
		processing: true,
		searching: true,
		buttons: ['copy', 'csv'],
		ajax: {
			type: 'POST',
			url: 'datatable<?php echo $ext?>',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo base64_encode($csrc); ?>',
				d.x= '<?php echo $menu?>';
			}
		},
		initComplete: function(){
			//dttbl_buttons(); //for ajax call
		}
	});
	//dttbl_buttons(); //remark this if ajax dttbl call
	jvalidate = $("#myf").validate({
    ignore: ":hidden:not(.selectpicker)",
	rules :{
        "sensor" : {
            required : true
        },
		"severity" : {
			required : true
		},
		"name" : {
			required : true
		},
		"mn" : {
			required : true,
			number : true
		},
		"mx" : {
			required : true,
			number : true
		}
    }});
	
	//datepicker();
	//timepicker();
	selectpicker(true);
});

function reloadtbl(){
	mytbl.ajax.reload();
}
function checkAndSave(){
	if($("#running").val()!='1'&&$("#startnow").val()!='1') {
		$("#startnow").val('1');
		saveData();
	}else{
		alrt('Backround Job is started, please wait.','error','Error');
	}
}
function toggle_checkbox(theid){
	//log($(theid).prop("checked"));
	if($(theid).prop("checked")==true){
		$("#startnow").val("0");
	}else{
		$("#startnow").val("1");
	}
}
</script>

  </body>
</html>