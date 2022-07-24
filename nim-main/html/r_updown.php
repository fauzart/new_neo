<?php 
include "inc.common.php";
include "inc.session.php";

$page_icon="fa fa-table";
$page_title="UP/Down";
$modal_title="";
$card_title="UP/Down Report";

$menu="-";

$breadcrumb="Reports-$page_title";

include "inc.head.php";
include "inc.menutop.php";

include "inc.db.php";

?>

<div class="app-content page-body">
	<div class="container">

		<!--Page header-->
		<div class="page-header">
			<div class="page-leftheader">
				<h4 class="page-title"><?php echo $page_title ?></h4>
				<ol class="breadcrumb pl-0">
					<?php echo breadcrumb($breadcrumb,"-")?>
				</ol>
			</div>
			<!--div class="page-rightheader">
				<a href="#" class="btn btn-primary" onclick="" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Create</a>
			</div-->
		</div>
		<!--End Page header-->
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="input-group col-md-2">
								<input type="text" id="df" placeholder="From Date" class="form-control datepicker">
								<div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
							</div>
							<div class="input-group col-md-2">
								<input type="text" id="dt" placeholder="To Date" class="form-control datepicker">
								<div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
							</div>
							&nbsp;&nbsp;&nbsp;
							<button type="button" onclick="submit_r_sla();" class="btn btn-primary col-md-1">Submit</button>
							
							<input type="hidden" id="tname">
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<div class="card-title"><?php echo $card_title?></div>
						<div class="card-options ">
							<a href="#" title="Expand/Collapse" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
							<!--a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a-->
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="mytbl" class="table table-striped table-bordered w-100">
								<thead>
									<tr>
										<th>Host</th>
										<th>Name</th>
										<th>Date/Time</th>
										<th>UP/Down</th>
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

<?php 
include "inc.foot.php";
include "inc.js.php";

$tname="core_log l left join core_node n on n.host=l.host";
$cols="l.host,n.name,l.dtm,if(status=1,'UP','DOWN') as stts";
$grpby="";
?>

<script>
var mytbl, jvalidate;
var today='<?php echo date('Y-m-d')?>';
var tname='<?php echo base64_encode($tname); ?>';
var tnamex='<?php echo base64_encode($tnamex); ?>';

$(document).ready(function(){
	page_ready();
	mytbl = $("#mytbl").DataTable({
		serverSide: true,
		processing: true,
		searching: false,
		buttons: ['copy', 'csv'],
		lengthMenu: [[10,50,100,500,-1],["10","50","100","500","All"]],
		ajax: {
			type: 'POST',
			url: 'datatable<?php echo $ext?>',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= tname,
				d.grpby= '<?php echo base64_encode($grpby); ?>',
				d.fdtmf= get_dt($("#df").val()),
				d.fdtmt= get_dt($("#dt").val()),
				d.x= '<?php echo $menu?>';
			}
		},
		initComplete: function(){
			dttbl_buttons(); //for ajax call
		}
	});
	//dttbl_buttons(); //remark this if ajax dttbl call
	datepicker(true);
	//timepicker();
	jvalidate = $("#myf").validate({
    rules :{
        "tx" : {
            required : true
        },
		"tm" : {
			required : true
		}
    }});
});

function get_tname(){
	return $("#df").val()==today||$("#df").val()==''?tname:tnamex;
}
function get_dt(dt){
	return $("#df").val()==today?"":dt;
}

function submit_r_sla(){
	mytbl.ajax.reload();
}
</script>

  </body>
</html>