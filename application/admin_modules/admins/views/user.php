<link rel="stylesheet" href="<?php echo base_url(); ?>themes/admin/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/admin/css/jquery.dataTables.min.css">
<script src="<?php echo base_url(); ?>themes/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>themes/admin/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>themes/admin/js/dataTables.responsive.min.js"></script>
<style>
	a:hover {
	color: #71748d;
	}
</style>
<main class="main">
    <br></br>
    <div class="container-fluid">
        <div class="animated fadeIn">            
            <div class="page-header">
				<a href="#newevent" class="float-right btn btn-primary" data-toggle="modal" id="cuns_btn">Add New</a>
				<h2 class="pageheader-title">Active Users</h2>
			</div>
			<div class="card">
				<div class="card-body" id="userTable">
					<?php echo $this->load->view('admins/viewuser'); ?>
				</div>
			</div>
			<div class="page-header">
				<h2 class="pageheader-title">Inactive Users</h2>
			</div>
			<div class="card">
				<div class="card-body" id="inactiveUserData">
					<?php echo $this->load->view('admins/inactive_user_view'); ?>
				</div>
			</div>            
        </div>
    </div>
	<!-- Add Consultants form modal start-->
	<div class="modal fade" id="newevent" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add User</h5>
					<a href="#" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<form id="Adduser-form">
						<input type="hidden" name="accessToken"  value="<?php echo $this->session->userdata('accessToken'); ?>">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">User ID (Auto generated)</label>
									<input type="text" class="form-control" id="id" name="admin_id" value="<?php echo getAutoincrimentId(); ?>" readonly>
								</div>
								<div class="form-group">
									<label class="col-form-label">User Name</label>
									<input type="text" class="form-control" id="name" name="name" value="" tabindex="2">
								</div>
								<div class="form-group">
									<label class="col-form-label">Address</label>
									<input type="text" class="form-control" id="address" name="address" value="" tabindex="4">
								</div>
								<div class="form-group">
									<label class="col-form-label">Status</label>
									<p>
										<label class="col-form-label" for="Contact Number" style="position: relative;">Inactive</label>&nbsp; &nbsp; 				
										<label class="switch">
											<input type="checkbox" id="" name="verified" checked tabindex="6">
											<span class="slider round"></span>
										</label>&nbsp; &nbsp; 			
										<label class="col-form-label" for="Contact Number" style="position: relative;">Active</label>
									</p>
								</div>
							</div>
							<div class="col-md-6">								
								<div class="form-group">
									<label class="col-form-label">Email ID</label>
									<input type="text" class="form-control" id="email" name="email" value="" tabindex="3">
								</div>
								<div class="form-group">
									<label class="col-form-label">Contact No</label>
									<input type="number" class="form-control" id="mobile_no" name="mobile_no" value="" tabindex="5">
								</div>								
							</div>
						</div>
					</form>	
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light" data-target="#golive" data-dismiss="modal">Close</a>
					<button type="button" id="add_user" class="btn btn-primary" tabindex="8">Save
						<i class="fa fa-spinner fa-spin" id="loader" style="display:none;float:right;padding: 5px;"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Consultants form modal end-->
	
	<!-- Edit Consultants form modal start -->
	<div class="modal fade" id="editevent" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit User</h5>
					<a href="#" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<form id="edit-user-form">
						<input type="hidden" name="accessToken"  value="<?php echo $this->session->userdata('accessToken'); ?>">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">User ID (Auto generated)</label>
									<input type="text" class="form-control" id="admin_id" name="admin_id" value="" readonly>
								</div>
								<div class="form-group">
									<label class="col-form-label">User Name</label>
									<input type="text" class="form-control" id="user_name" name="name" value="" tabindex="2">
								</div>
								<div class="form-group">
									<label class="col-form-label">Address</label>
									<input type="text" class="form-control" id="user_address" name="address" value="" tabindex="3">
								</div>
								<div class="form-group">
									<label class="col-form-label">Status</label>
									<p>
										<label class="col-form-label" style="position: relative;">Inactive</label>&nbsp; &nbsp; 
										<label class="switch">
											<input type="checkbox" id="isVerified" name="verified" tabindex="5">
											<span class="slider round"></span>
										</label>&nbsp; &nbsp; 		
										<label class="col-form-label"  style="position: relative;">Active</label>
									</p>
								</div>
							</div>
							<div class="col-md-6">								
								<div class="form-group">
									<label class="col-form-label">Email ID</label>
									<input type="text" class="form-control" id="user_email" name="email" value="" readonly>
								</div>
								<div class="form-group">
									<label class="col-form-label">Contact No</label>
									<input type="number" class="form-control" id="user_phone_no" name="mobile_no" value="" tabindex="4">
								</div>								
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light" data-dismiss="modal">Close</a>
					<button type="button" id="update-user" class="btn btn-primary" tabindex="6">Update
						<i class="fa fa-spinner fa-spin" id="updateloader" style="display:none;float:right;padding: 5px;"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Edit Consultants form modal end -->
	
	<!-- Delete consultants start -->
	<div class="modal fade" id="delete_consultants" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Delete User</h5>
					<a href="#" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<input type="hidden" id="user_id" name="user_id" class="form-control" value="">
					<p>Are you sure you want to go delete User</p>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light" data-dismiss="modal">No, Go Back</a>
					<button type="button" id="delete_user" class="btn btn-primary">Yes, Go Delete User</a>
				</div>
			</div>
		</div>
	</div>
	<!-- Delete consultants end -->
	
	<!-- Change Password consultants start -->
	<div class="modal fade" id="chanegpass_consultants" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Reset Password</h5>
					<a href="#" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<input type="hidden" id="user_id" name="user_id" class="form-control" value="">
					<form id="reset_pass">
						<input type="hidden" name="users_id"  id="users_id" value="">
						<input type="hidden" name="accessToken"  value="<?php echo $this->session->userdata('accessToken'); ?>">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-form-label">New Password</label>																	
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter new password">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-form-label">Confirm Password</label>																	
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Enter new password">
								</div>
							</div>							
						</div>	
					</form>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-light" data-dismiss="modal">Cancel</a>
					<button type="button" id="resetpass" class="btn btn-primary">Reset</a>
				</div>
			</div>
		</div>
	</div>
	<!-- Delete consultants end -->	
</main>
<script src="<?php echo base_url();?>themes/admin/js/usermanage.js"></script>