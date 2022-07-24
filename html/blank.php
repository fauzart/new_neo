<?php 
include "inc.common.php";
include "inc.session.php";

$page_icon="fa fa-home";
$page_title="Title of Page";
$modal_title="Title of Modal";
$menu="maps";

$breadcrumb="Parent/$page_title";

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
						
						
						
					</div>
				</div><!-- end app-content-->
				
<?php 
include "inc.foot.php";
include "inc.js.php";
?>
<script>
$(document).ready(function(){
	page_ready();
})
</script>

  </body>
</html>