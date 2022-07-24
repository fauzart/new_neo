<?php include "inc.header.php"; ?>
				
				<!-- Horizontal-menu -->
				<div class="horizontal-main hor-menu clearfix">
					<div class="horizontal-mainwrapper container clearfix">
						<nav class="horizontalMenu clearfix">
							<ul class="horizontalMenu-list">
								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-dashboard"></i> Overview <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true" class="home"><a class="home" href="home<?php echo $ext?>">Summary</a></li>
										<li aria-haspopup="true" class="maps"><a class="maps" href="maps<?php echo $ext?>">Locations</a></li>
									</ul>
								</li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-code-fork"></i> Nodes <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true"><a href="n_device<?php echo $ext?>">Devices</a></li>
										<li aria-haspopup="true"><a href="n_location<?php echo $ext?>">Locations</a></li>
									</ul>
								</li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-plug"></i> Plugins <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true"><a href="p_snmpd<?php echo $ext?>">SNMP</a></li>
										<!--li aria-haspopup="true"><a href="p_syslog<?php echo $ext?>">Syslog</a></li>
										<li aria-haspopup="true"><a href="p_nmap<?php echo $ext?>">IP Scan</a></li>
										<li aria-haspopup="true"><a href="p_conf<?php echo $ext?>">Configs</a></li>
										<li aria-haspopup="true"><a href="p_apps<?php echo $ext?>">Application</a></li-->
									</ul>
								</li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-file-text-o"></i> Reports <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true"><a href="r_device<?php echo $ext?>">Device</a></li>
										<li aria-haspopup="true"><a href="r_location<?php echo $ext?>">Location</a></li>
										<li aria-haspopup="true"><a href="r_sla<?php echo $ext?>">SLA</a></li>
										<li aria-haspopup="true"><a href="r_perf<?php echo $ext?>">Performance</a></li>
										<li aria-haspopup="true"><a href="r_severity<?php echo $ext?>">Severity</a></li>
										<li aria-haspopup="true"><a href="r_updown<?php echo $ext?>">Up/Down</a></li>
									</ul>
								</li>
	<?php if($s_LVL<2){ ?>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-cogs"></i> Setup <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
			<?php if($s_LVL==0){ ?>
										<li aria-haspopup="true"><a href="m_user<?php echo $ext?>">User</a></li>
			<?php }?>
										<li aria-haspopup="true"><a href="m_severity<?php echo $ext?>">Severity</a></li>
										<li aria-haspopup="true"><a href="m_sla<?php echo $ext?>">SLA</a></li>
										<li aria-haspopup="true"><a href="m_loc<?php echo $ext?>">Location</a></li>
										<li aria-haspopup="true"><a href="m_device<?php echo $ext?>">Device</a></li>
										<!--li aria-haspopup="true"><a href="m_ip<?php echo $ext?>">IP Scan</a></li-->
										<li aria-haspopup="true"><a href="m_bg<?php echo $ext?>">Background Job</a></li>
									</ul>
								</li>
	<?php }?>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-wrench"></i> Tools <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true"><a href="t_ping<?php echo $ext?>">Ping</a></li>
										<li aria-haspopup="true"><a href="t_trace<?php echo $ext?>">Trace</a></li>
										<li aria-haspopup="true"><a href="t_snmp<?php echo $ext?>">SNMP</a></li>
										<!--li aria-haspopup="true"><a href="t_scan<?php echo $ext?>">IP Scan</a></li>
										<li aria-haspopup="true"><a href="t_config<?php echo $ext?>">Config</a></li-->
									</ul>
								</li>
								
							</ul>
						</nav>
						<!--Nav end -->
					</div>
				</div>
				<!-- Horizontal-menu end -->
