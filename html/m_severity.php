<?php 
$restrict_lvl=array("0","1");

include "inc.common.php";
include "inc.session.php";

$page_icon="fa fa-table";
$page_title="Severity";
$modal_title="Severity";
$card_title="Master $page_title";

$menu="severity";

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
							<!--a href="#" title="Batch" class=""><i class="fe fe-upload"></i></a-->
							<a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#myModal" title="Add" class=""><i class="fe fe-plus"></i></a>
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
										<th>Sensor</th>
										<th>Network</th>
										<th>Min</th>
										<th>Max</th>
										<th>Severity</th>
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
<input type="hidden" name="cols" value="sensor,name,net,mn,mx,severity" />
<input type="hidden" name="tname" value="core_severity" />
		
		  <div class="row">
			<div class="form-group col-md-6">
				<label>Name</label>
				<input type="text" id="name" name="name" placeholder="..." class="form-control">
			</div>
			<div class="form-group col-md-6">
				<label>Sensor</label>
				<select class="form-control selectpicker" id="sensor" name="sensor">
					<option value="">-</option>
					<?php echo options($o_ssensor)?>
				</select>
			</div>
		  </div>
		  <div class="row">
			<div class="form-group col-md-6">
				<label>Min</label>
				<input type="text" id="mn" name="mn" placeholder="..." class="form-control">
			</div>
			<div class="form-group col-md-6">
				<label>Max</label>
				<input type="text" id="mx" name="mx" placeholder="..." class="form-control">
			</div>
		  </div>
		  <div class="row">
			<div class="form-group col-md-6">
				<label>Network</label>
				<input type="text" id="net" name="net" placeholder="..." class="form-control">
			</div>
			<div class="form-group col-md-6">
				<label>Severity</label>
				<select class="form-control selectpicker" id="severity" name="severity">
					<option value="">-</option>
					<?php echo options($o_sseverity)?>
				</select>
			</div>
		  </div>
		</form>
	  </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-danger" id="bdel"  onclick="confirmDelete();">Delete</button>
		<button type="button" class="btn btn-success" onclick="saveData();">Save</button>
		<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
		
	  </div>
	</div>
  </div>
</div>

<?php 
include "inc.foot.php";
include "inc.js.php";

$tname="core_severity";
$cols="name,sensor,net,mn,mx,severity,rowid";
$csrc="net,name";

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
</script>

  </body>
</html>