<?php
$redirect=false;
$datatable=true;

include 'inc.session.php';
include 'inc.common.php';
include 'lib_inc.db.php';

$conn = connect();

$x=post("x",$conn,"");
if($x==""){
	$output = array(
          "draw"=>1,
          "recordsTotal"=>0, // total number of records 
          "recordsFiltered"=>0, // if filtered data used then tot after filter
          "data"=>array(),
		  "msgs"=>"X is blank"
        );
	echo json_encode($output);
	
	exit;
}
$tname=base64_decode(post("tname",$conn));
$cols=base64_decode(post("cols",$conn));
$where=base64_decode(post("where",$conn));
$csrc=base64_decode(post("csrc",$conn));
$cseq=base64_decode(post("cseq",$conn));

$grpcol=base64_decode(post("grpcol",$conn));
$grpby=base64_decode(post("grpby",$conn));
$grpcol=$grpcol==""?$grpby:$grpcol;
$grpby=$grpby!=""?" group by $grpby":"";

$having=base64_decode(post("having",$conn));
$having=$having!=""?" having $having":"";

//filters
$where=get_params($where,$conn,explode(",",post("filtereq")),"=");
$where=get_params($where,$conn,explode(",",post("filtergt")),">");
$where=get_params($where,$conn,explode(",",post("filtergteq")),">=");
$where=get_params($where,$conn,explode(",",post("filterlt")),"<");
$where=get_params($where,$conn,explode(",",post("filterlteq")),"<=");
$where=get_params($where,$conn,explode(",",post("filterlike")),"like");
$where=get_params($where,$conn,explode(",",post("filterin")),"in");
$where=get_params($where,$conn,explode(",",post("filternotin")),"not in");

//specific param with col modif
$param=isset($_POST['fdf']) ? $_POST['fdf']:"";
	if($param!=""){
		$where=$where!=""?"$where and dt>='$param'":"dt>='$param'";
	}
$param=isset($_POST['fdt']) ? $_POST['fdt']:"";
	if($param!=""){
		$where=$where!=""?"$where and dt<='$param'":"dt<='$param'";
	}

/*tablename is tname plus where*/
$tablename=$tname;
if($where!=""){
	$tablename.=" where ($where)";
}

/*get field name*/
$result = exec_qry($conn,"select ".$cols." from ".$tablename." ".$grpby." limit 0");
$acol=array();
while($field = fetch_field($result)){
	$acol[]=$field->name;
}
$col=count($acol);

/*total record, use select count(), faster than recordcount from result*/
$sqlcount=$grpcol==""?"select count(*) as cntstar from $tablename":"select count(*) as cntstar from (select distinct $grpcol from $tablename) mytbl";
$result = exec_qry($conn,$sqlcount);
$iTotal = 0;
while($row=fetch_row($result)){
	$iTotal+=$row[0];
}
$iFilteredTotal = $iTotal;

/*limit*/
$draw = $_POST["draw"];
$limit="";
if ( isset($_POST['start']) && $_POST['length'] != -1 ) {
	$limit = "LIMIT ".intval($_POST['start']).", ".intval($_POST['length']);
}

/*search*/
$str = esc_str($conn,$_POST["search"]["value"]);
$search = "";
if($str!=""){
	if($csrc!=""){
		$acs=explode(",",$csrc);
		for($j=0;$j<count($acs);$j++){
			$search.=" or ".$acs[$j]." like '%".$str."%'";
		}
	}
	if($cseq!=""){
		$acseq=explode(",",$cseq);
		for($j=0;$j<count($acseq);$j++){
			$search.=" or ".$acseq[$j]." = '".$str."'";
		}
	}
	if($where==""){
		$search=" where 1=0".$search;
	}else{
		$search=" and (1=0".$search.")";
	}
}

/*total record, after search*/
if($search!=""){
$sqlcount=$grpcol==""?"select count(*) as cntstar from $tablename $search":"select count(*) as cntstar from (select distinct $grpcol from $tablename $search) mytbl";
$result = exec_qry($conn,$sqlcount);
if($row=fetch_row($result)){
	$iFilteredTotal=$row[0];
}
}

/*sorting*/
$order="";
$ordercol=$_POST["order"][0]["column"];
$orderdir=$_POST["order"][0]["dir"];
if($ordercol<=$col){
	$order=" order by ".$acol[$ordercol]." ".$orderdir;
}

/*construct sql, exec and build output*/
$sql = "select ".$cols." from ". $tablename ." ".$search." ".$grpby." ".$having." ".$order." ".$limit;
//echo $sql;

$result = exec_qry($conn,$sql);

$output = array(
          "draw"=>$draw,
          "recordsTotal"=>$iTotal, // total number of records 
          "recordsFiltered"=>$iFilteredTotal, // if filtered data used then tot after filter
          "data"=>array(),
		  "msgs"=>""
        );
if(!$production){ $output["msgs"] = $sql;} //debug for dev

$i=0;
$xx="";
while($row = fetch_row($result)){
	$i++;
	$act="";
	
	//$act='<a title="Edit" href="#" class="btn btn-warning" data-toggle="modal" data-target="#modal_large" onclick="openForm(\''.$row[$col-1].'\');"><i class="fa fa-pencil"></i></a>';
	//$act.='&nbsp;<a title="Delete" href="#" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete" onclick="openDelete(\''.$row[$col-1].'\');"><i class="fa fa-trash"></i></a>';
	
	if($x=='project'){
		$act='<a title="Overview" style="padding-top:0;padding-bottom:0;" class="btn btn-outline-secondary" href="JavaScript:;" data-fancybox data-type="iframe" data-src="overview'.$ext.'?id='.$row[0].'"><i class="fa fa-th-large"></i></a>';
		$row[$col-2]=$act;
	}
	
	if($x=="ndevice"){
		$h=$row[0];
		$idx=$row[$col-1];
		$act='<a title="Overview" class="dttbl" href="JavaScript:;" data-fancybox data-type="iframe" data-src="lib_device'.$ext.'?h='.$h.'&idx='.$idx.'">'.$h.'</a>';
		$row[0]=$act;
		$xx='-';
	}
	
	if($x!="-"&&$xx!="-"){ //- means no need to modify first column
		$row[0]='<a href="#" class="dttbl"  title="Open" data-toggle="modal" data-target="#myModal" onclick="openForm(\''.$x.'\',\''.$row[$col-1].'\');">'.$row[0].'&nbsp;</a>';
	}
	
	$output["data"][] = $row ;
}

disconnect($conn);

echo json_encode( $output );
?>