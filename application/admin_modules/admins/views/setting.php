<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/admin/css/croppie.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/admin/css/setting.css">
<main class="main">
    <br></br>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-fill">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#m_tabs_2_1"><b>Settings</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#m_tabs_2_2"><b>Change Password</b></a>
                        </li>
                    </ul>
                    <div class="tab-content" style="padding-top: 40px;">
                        <div class="tab-pane active" id="m_tabs_2_1">
                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-5">
                                    <form id="submit_profile_data">
                                        <input type="hidden" name="accessToken" value="<?php echo $this->session->userdata('accessToken'); ?>">
                                        <input type="hidden" name="users_id" value="<?php echo $this->session->userdata('login_Id'); ?>">
                                        <div class="form-group row">
                                            <label class="col-form-label col-4"><b>Name :</b></label>
                                            <input class="form-control col-8" id="name" type="text" name="name" value="<?php echo ($usersdata[0]->name ? $usersdata[0]->name : ''); ?>" autocomplete="off">
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-4"><b>Email :</b></label>
                                            <input class="form-control col-8" id="email" type="text" name="email" value="<?php echo ($usersdata[0]->email ? $usersdata[0]->email : ''); ?>" disabled>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-4"><b>Address :</b></label>
                                            <input class="form-control col-8" id="address" type="text" name="address" value="<?php echo ($usersdata[0]->address ? $usersdata[0]->address : ''); ?>" autocomplete="off">
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-4"><b>Phone No :</b></label>
                                            <input class="form-control col-8" id="mobile_no" type="number" name="mobile_no" value="<?php echo ($usersdata[0]->mobile_no ? $usersdata[0]->mobile_no : ''); ?>" autocomplete="off">
                                        </div>
                                        <div class="row">
                                            <label class="col-form-label col-md-4"></label>
                                            <div class="form-group col-md-8" style="text-align: center;">
                                                <button type="button" id="submitprofile" class="btn btn-primary">Submit
                                                    <i class="fa fa-spinner fa-spin" id="update_profileLoader" style="display:none;float:right;padding: 5px;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6" style="text-align: center;">
                                    <p class="col-form-label" style="font-size:24px;color: #3f4047;">Profile picture</p>
                                    <?php
										if (file_exists('uploads/adminLogo/' . ($usersdata[0]->profile_pic))) {
											if ($usersdata[0] && $usersdata[0]->profile_pic) {
												$userprofileimage = $usersdata[0]->profile_pic;
											}
											} else {
											$userprofileimage = 'defaultUser.png';
										}
										?>
                                        <a href="#profile_image" data-toggle="modal" alt="Chanege Profile">
											<img profile_img="<?php echo $userprofileimage; ?> " data-toggle="m-tooltip" data-original-title="To change your profile picture, click on it" src="<?php echo base_url() . 'uploads/adminLogo/' . $userprofileimage; ?>" style="cursor: pointer;width: 150;height: 220px;" id="Modals_Img" class="profile_model img-responsive img-circle collectionImg" alt="Chanege Profile"/>
										</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="m_tabs_2_2">
                            <div class="row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-5">
                                    <form id="reset_pass">
                                        <input type="hidden" name="accessToken" value="<?php echo $this->session->userdata('accessToken'); ?>">
                                        <input type="hidden" name="users_id" value="<?php echo $this->session->userdata('login_Id'); ?>">
                                        <div class="form-group row">
                                            <label class="col-form-label col-5"><b>New Password : </b></label>
                                            <input class="form-control col-7" id="newPassword" type="password" name="newPassword" autocomplete="off" placeholder="Enter new password">
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-5"><b>Confirm Password : </b></label>
                                            <input class="form-control col-7" id="confirmPassword" type="password" name="confirmPassword" autocomplete="off" placeholder="Confirm new password">
                                        </div>
                                        <div class="row">
                                            <label class="col-form-label col-4"></label>
                                            <div class="form-group col-8" style="text-align: center;">
                                                <button type="button" id="resetpass" class="btn btn-primary">Change Password
                                                    <i class="fa fa-spinner fa-spin" id="resetlodaer" style="display:none;float:right;padding: 5px;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="profile_image" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Profile Logo</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="submit_profile_img" method="post">
                        <input type="hidden" name="accessToken" value="<?php echo $this->session->userdata('accessToken'); ?>">
                        <input type="hidden" name="users_id" value="<?php echo $this->session->userdata('login_Id'); ?>">
                        <input type="hidden" name="upload_imgval" id="upload_imgval" value="0">
                        <div class="file-field input-field" style="text-align: center;">
                            <div style="margin-bottom: 11px;">
                                <label class="">
                                    <input type="file" id="upload" class="">
                                </label>
                            </div>
                            <div id="upload-demo"></div>
                            <input type="hidden" id="imagebase64" name="imagebase64">
                            <input type="hidden" class="" style="margin-left:320px;" name="image_name" id="image_name" value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-light" data-dismiss="modal">Cancel</a>
                    <button type="button" class="btn btn-primary" id="Upload_adminimage">Save
                        <i class="fa fa-spinner fa-spin" id="update_imageLoader" style="display:none;float:right;padding: 5px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>themes/admin/js/croppie.js"></script>
    <script src="<?php echo base_url(); ?>themes/admin/js/setting.js"></script>
</main>