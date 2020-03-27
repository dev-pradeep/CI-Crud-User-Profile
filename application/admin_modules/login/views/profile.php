<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/admin/css/croppie.css">
<script src="<?php echo base_url(); ?>themes/admin/js/croppie.js"></script>
<link href="<?php echo base_url() ?>./themes/admin/css/dasboard.css" rel="stylesheet" type="text/css" />
<style>
	@-webkit-keyframes spin {
	0% { -webkit-transform: rotate(0deg); }
	100% { -webkit-transform: rotate(360deg); }
	}
	@keyframes spin {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
	}
	.title_fon
	{
	font-weight: 700 !important;
	text-transform: uppercase !important;
	}
	.croppie-container .cr-slider-wrap {
	width: 37%!important;
	}
	.cr-boundary{
	width: 401px;
	height: 300px;
	}
</style>
<script>
	$('.dropdown-toggle').dropdown();
</script>
<!-- END: Left Aside -->
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="m-portlet m-portlet--creative m-portlet--bordered-semi">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h2 class="m-portlet__head-label m-portlet__head-label--success" style="width: 100px;">
							<span>Profile</span>
						</h2>
					</div>
				</div>
				<div class="m-portlet__body">
					<ul class="nav nav-tabs nav-fill" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#m_tabs_2_1">Settings</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#m_tabs_2_2">Change Password</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="m_tabs_2_1" role="tabpanel">
							<div class="m-section__content col-md-6"  style="margin-left: calc(100% - 75%);">
								<div class="row">
									<?php
										if (file_exists('uploads/adminLogo/' . ($usersdata[0]->profile_pic))) {
											if ($usersdata[0] && $usersdata[0]->profile_pic) {
												$userprofileimage = $usersdata[0]->profile_pic;
											}
											} else {
											$userprofileimage = 'defaultUser.png';
										}
									?>
									<div class="col-md-4">
									</div>
									<div class="col-md-4">
										<img profile_img="<?php echo $userprofileimage; ?> " data-toggle="m-tooltip" data-original-title="To change your profile picture, click on it" src="<?php echo base_url() . 'uploads/adminLogo/' . $userprofileimage; ?>" style="cursor: pointer;width: 150;height: 150px;" id="Modals_Img" class="profile_model img-responsive img-circle collectionImg" alt=""/>
										</br></br>
									</div>
								</div>
								<div class="example-box-wrapper" id="submit_email">
									<form class="form-horizontal" id="submit_profile_data">
										<input type="hidden" name="accessToken"  value="<?php echo $this->session->userdata('accessToken'); ?>">										
										<input type="hidden" name="users_id"  value="<?php echo $this->session->userdata('login_Id'); ?>">										
										<div class="form-group row">
											<label class="col-lg-3 control-label">Name</label>
											<div class="col-lg-6">
												<input type="text" class="form-control" name="name" id="name" placeholder="" value="<?php echo ($usersdata[0]->name ? $usersdata[0]->name : ''); ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-lg-3 control-label">Email</label>
											<div class="col-lg-6">
												<input type="text" class="form-control" name="email" id="email" placeholder="" value="<?php echo ($usersdata[0]->email ? $usersdata[0]->email : ''); ?>" disabled>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<label class="col-lg-3 control-label"></label>
										<div class="col-lg-6">
											<button type="button" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="submitprofile">Submit</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="m_tabs_2_2" role="tabpanel">
							<br></br>                        
							<div class="m-section__content col-md-6"  style="margin-left: calc(100% - 75%);">
								<form class="form-horizontal" id="reset_pass">
									<input type="hidden" name="accessToken"  value="<?php echo $this->session->userdata('accessToken'); ?>">									
									<input type="hidden" name="users_id"  value="<?php echo $this->session->userdata('login_Id'); ?>">
									<div class="form-group row">
										<label class="col-lg-3 control-label">New Password</label>
										<div class="col-lg-6">
											<input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter new password...">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 control-label">Confirm Password</label>
										<div class="col-lg-6">
											<input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Enter new password...">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-lg-1 control-label"></label>
											<div class="col-lg-11" style="margin-left: -16%;">											
												<button type="button" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="resetpass" style="margin-left:36%;">Submit</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>themes/admin/js/profile_manage.js"></script>
