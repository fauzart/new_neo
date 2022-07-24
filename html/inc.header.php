				<div class="header top-header">
					<div class="container">
						<div class="d-flex">
							<a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a><!-- sidebar-toggle-->
							<a class="header-brand" href="home<?php echo $ext?>">
								<img src="aronox/assets/images/brand/logo.png" class="header-brand-img desktop-lgo" alt="Aronox logo">
								<img src="aronox/assets/images/brand/favicon.png" class="header-brand-img mobile-logo" alt="Aronox logo">
							</a>

							<div class="mt-1">
								<form class="form-inline" method="POST" action="n_device<?php echo $ext?>">
									<div class="search-element">
										<input name="cari" type="search" class="form-control header-search" placeholder="Search..." aria-label="Search" tabindex="1">
										<button class="btn btn-primary-color" type="submit"><i class="fa fa-search"></i></button>
									</div>
								</form>
							</div><!-- SEARCH -->

							<div class="d-flex order-lg-2 ml-auto">
								<a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch"><i class="fa fa-search"></i></a>
								<div class="dropdown   header-fullscreen" >
									<a  class="nav-link icon full-screen-link"  id="fullscreen-button">
										<i class="mdi mdi-arrow-collapse"></i>
									</a>
								</div>
								<!--div class="dropdown d-md-flex message hidden">
									<a class="nav-link icon text-center" data-toggle="dropdown">
										<i class="mdi mdi-email-outline"></i>
										<span class="nav-unread bg-warning-1 pulse"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a href="#" class="dropdown-item d-flex mt-2 pb-3">
											<div class="avatar avatar-md brround mr-3 d-block cover-image" data-image-src="aronox/assets/images/users/5.jpg">
												<span class="avatar-status bg-green"></span>
											</div>
											<div>
												<strong>Madeleine</strong>
												<p class="mb-0 fs-13">Hey! there I' am available</p>
												<div class="small">3 hours ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="avatar avatar-md brround mr-3 d-block cover-image" data-image-src="aronox/assets/images/users/8.jpg">
												<span class="avatar-status bg-red"></span>
											</div>
											<div>
												<strong>Anthony</strong>
												<p class="mb-0 fs-13 ">New product Launching</p>
												<div class="small">5  hour ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="avatar avatar-md brround mr-3 d-block cover-image" data-image-src="aronox/assets/images/users/11.jpg">
												<span class="avatar-status bg-yellow"></span>
											</div>
											<div>
												<strong>Olivia</strong>
												<p class="mb-0 fs-13 ">New Schedule Realease</p>
												<div class="small">45 mintues ago</div>
											</div>
										</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">See all Messages</a>
									</div>
								</div><!-- MESSAGE-BOX -->

								<!--div class="dropdown header-notify">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="mdi mdi-bell-outline"></i>
										<span class="pulse bg-danger hidden"></span>
									</a>
									<div id="lonceng" class="hidden">
									<div id="isilonceng" class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									
									</div>
									</div>
								</div-->
								
								<div class="dropdown ">
									<a class="nav-link pr-0 leading-none" href="#" data-toggle="dropdown" aria-expanded="false">
									    <div class="profile-details mt-2">
											<span class="mr-3 font-weight-semibold"><?php echo $s_ID==""?"Noone":$s_ID?></span>
											<small class="text-muted mr-3"><?php echo getVal($s_LVL,$o_ulvl)?></small>
										</div>
										<img class="avatar avatar-md brround" src="<?php echo $s_AVATAR==""?"avatars/logo.jpg":"avatars/$s_AVATAR"?>" alt="image">
									 </a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
										<a class="dropdown-item" href="profile<?php echo $ext?>">
											<i class="dropdown-icon mdi mdi-account-outline "></i> My Profile
										</a>
										<a class="dropdown-item" href="logout<?php echo $ext?>">
											<i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
										</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#" onclick="modal(atob('<?php echo $about[0]?>'),atob('<?php echo $about[1]?>'));">
											<i class="dropdown-icon mdi  mdi-at"></i> About
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
