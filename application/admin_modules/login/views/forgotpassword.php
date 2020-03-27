<body class="app flex-row align-items-center">
    <input type="hidden" id="base_url" value="<?php echo base_url();?>" />	
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h4>Forgotten Password ?</h4>                            
                             <form id="frmPopupforgot">
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">
										  <i class="icon-user"></i>
										</span>
									</div>
									<input class="form-control" id="m_email" type="email" name="recoverEmail" placeholder="Your Email ID" autocomplete="off">
								</div>								
							</form>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" id="btnPopupForgot"  type="button">Request
									<i class="fa fa-spinner fa-spin" id="forgot_loader" style="display:none;float:right;padding: 5px;"></i>
									</button>
                                </div>
                                <div class="col-6 text-right">
                                    <a class="btn btn-link px-0" href="<?php echo base_url('login');?>" class="footer-link">Login</a>									
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