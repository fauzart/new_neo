<?php
include "inc.common.php";
include 'inc.db.php';

$user=post('user');
$passwd=post('passwd');
$loggedin=false;
$m=get('m');
$x=get('x');

if($user!=''&&$passwd!=''){
	$conn=connect();
	$sql="select uid, uname, ulvl, ugrp, uprof, uavatar from core_user where (uid='$user') and upwd=MD5('$passwd')";
	$rs = exec_qry($conn,$sql);
	if ($row = fetch_row($rs)) {
		session_start();
		
		$_SESSION['s_ID'] = $user;
		$_SESSION['s_NAME'] = $row[1];
		$_SESSION['s_LVL'] = $row[2];
		$_SESSION['s_GRP'] = $row[3];
		$_SESSION['s_PROF'] = $row[4];
		$_SESSION['s_AVATAR'] = $row[5];
		
		$loggedin=true;
	}else{
		$m='Wrong username/password';
		$x='error';
	}
	disconnect($conn);
}
if($loggedin){
	header("Location: home$ext");
}

include "inc.head.php";
$menu="";
?>
				<div class="container text-center single-page single-pageimage construction-body">
				    <div class="row">
						<div class="col-xl-7 col-lg-6 col-md-12">
							<img src="aronox/assets/images/svgs/login.svg" class="construction-img mb-7 h-480  mt-5 mt-xl-0" alt="">
						</div>
						<div class="col-xl-5  col-lg-6 col-md-12 ">
							<div class="col-lg-11">
							    <img src="aronox/assets/images/brand/logo.png" class="header-brand-img light-view mb-4" alt="Aronox logo">
								<div class="wrapper wrapper2">
									<form id="login" method="post" class="card-body" tabindex="500">
										<h2 class="mb-1 font-weight-semibold">Login</h2>
										<p class="mb-6">Sign In to your account</p>
										<div class="input-group mb-3">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<input type="text" name="user" class="form-control" placeholder="Username" value="<?php echo $user?>">
										</div>
										<div class="input-group mb-4">
											<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
											<input type="password" name="passwd" class="form-control" placeholder="Password" value="<?php echo $passwd?>">
										</div>
										<div class="row mb-0">
											<div class="col-12">
												<button type="submit" onclick="if($('#login').valid()){this.form.submit();}" class="btn btn-primary btn-block">Login</button>
											</div>
											<div class="col-12 mb-0">
												<!--a href="forgot-password.html" class="btn btn-link box-shadow-0 px-0">Forgot password?</a>
												<p class=" mb-0">Don't have account?<a href="register.html" class="text-primary ml-1">Sign UP</a></p-->
											</div>
										</div>
									</form>
									<div class="card-body social-icons border-top">
										<!--a class="btn  btn-social btn-fb mr-2"><i class="fa fa-facebook"></i> </a>
										<a class="btn  btn-social btn-googleplus mr-2"><i class="fa fa-google-plus"></i></a>
										<a class="btn  btn-social btn-twitter-transparant  "><i class="fa fa-twitter"></i></a-->
										Network Information and Monitoring
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
<?php
include "inc.foot.php";
include "inc.js.php";
?>
<script>
var x="<?php echo $x?>";
var m="<?php echo $m?>";
var jvalidate;
$(document).ready(function (){
	$(".page-main").addClass("page-single");
	jvalidate = $("#login").validate({
    rules :{
        "user" : {
            required : true
        },
		"passwd" : {
			required : true
		}
    }});
	showAlert();
});

function showAlert(){
	if(m!=""){
		alrt(m,x);
	}
}
</script>
  </body>
</html>