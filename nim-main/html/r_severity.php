<?php 
include "inc.common.php";
include "inc.session.php";

$page_icon="fa fa-table";
$page_title="Severity";
$modal_title="";
$card_title="Severity Report";

$menu="-";

$breadcrumb="Reports/$page_title";

include "inc.head.php";
include "inc.menutop.php";

include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select concat(sensor,'|',mn,'|',mx,'|',severity) as val, name from core_severity order by name");
$o_severity=fetch_all($rs);
disconnect($conn);

if(count($o_severity)>0){
	$svr=explode("|",$o_severity[0][0]);
}else{
	$svr=array("status","9","9","-");
}
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
					<div class="card-body">
						<div class="row">
							<select class="form-control selectpicker col-md-3" id="severity" name="severity">
								<?php echo options($o_severity)?>
							</select>
							&nbsp;&nbsp;&nbsp;
							<button type="button" onclick="submit_r_severity();" class="btn btn-primary col-md-1">Submit</button>
							
							<input type="hidden" id="cols" value="n.host,n.name,n.net,n.typ,">
							<input type="hidden" id="fld" value="<?php echo $svr[0]?>">
							<input type="hidden" id="min" value="<?php echo $svr[1]?>">
							<input type="hidden" id="max" value="<?php echo $svr[2]?>">
							<input type="hidden" id="svr" value="<?php echo $svr[3]?>">
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
										<th>Network</th>
										<th>Type</th>
										<th>Value</th>
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

<?php 
include "inc.foot.php";
include "inc.js.php";


$tname="core_node n left join core_status s on n.host=s.host";

?>

<script>
var mytbl, jvalidate;
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
				d.cols= btoa($("#cols").val()+$("#fld").val()+",'"+$("#svr").val()+"'"),
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.where= btoa($("#fld").val()+'>='+$("#min").val()+' and '+$("#fld").val()+'<='+$("#max").val()),
				d.x= '<?php echo $menu?>';
			}
		},
		initComplete: function(){
			dttbl_buttons(); //for ajax call
		}
	});
	//dttbl_buttons(); //remark this if ajax dttbl call
	//datepicker(true);
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

function submit_r_severity(){
	var a=$("#severity").val().split("|");
	$("#fld").val(a[0]);
	$("#min").val(a[1]);
	$("#max").val(a[2]);
	$("#svr").val(a[3]);
	
	mytbl.ajax.reload();
}
</script>

  </body>
</html>