<?php 
$redirect=false;
$cleartext=true;

include "inc.common.php";
include "inc.session.php";

include "inc.db.php";

$h=post("h");
$g=post("g");
$c=post("c");
$df=post("df")." 00:00:00";
$dt=post("dt")." 23:59:59";

$b=strtotime($df);
$e=strtotime($dt);
$g=$g=="jitter"?"mdev":$g;

echo '<img width="100%" src="/cgi-bin/'.$g.'.sh?h='.$h.'&b='.$b.'&e='.$e.'&c='.$c.'">';
?>
