<body class="app flex-row align-items-center">
    <input type="hidden" id="base_url" value="<?php echo base_url();?>" />	
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Login</h1>
                            <p class="text-muted">Sign In to your account</p>
                            <form id="frmSignIn">
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">
										  <i class="icon-user"></i>
										</span>
									</div>
									<input class="form-control" id="uEmail" type="email" name="email" placeholder="Your Email ID">
								</div>
								<div class="input-group mb-4">
									<div class="input-group-prepend">
										<span class="input-group-text">
										  <i class="icon-lock"></i>
										</span>
									</div>
									<input class="form-control" id="uPass" type="password" name="password" placeholder="Password">
								</div>
							</form>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" id="btnSignIn"  type="button"><i class="fa fa-spinner fa-spin" id="signin_loader" style="display:none;float:right;padding: 5px;"></i>Login</button>
                                </div>
                                <div class="col-6 text-right">
                                    <a class="btn btn-link px-0" href="<?php echo base_url('login/forgotpassword');?>" class="footer-link">Click to Reset</a>									
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo base_url() ?>themes/admin/js/signin.js"></script>