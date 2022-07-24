<?php
$redirect=false;
$cleartext=true;

include "inc.common.php";
include "inc.session.php";
include "inc.db.php";

$conn=connect();

$rs=exec_qry($conn,"select if(prov='' or prov is null,'Undefined',prov) as prv, count(host) as cnt from core_node n left join core_location l on n.loc=l.locid group by prov order by prov");
$lists=fetch_all($rs);

disconnect($conn);
for($i=0;$i<count($lists);$i++){
?>
<tr class="border-bottom">
	<td class="p-2"><i class="flag flag-id mt-2 mr-2"></i><?php echo $lists[$i][0]?></td>
	<td class="p-2 pb-0 pt-3 text-right"><?php echo $lists[$i][1]?></td>
</tr>
<?php
}
?>