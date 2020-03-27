<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8" />
    <title>
        <?php echo (@$title)?$title:$this->config->item('applicationName');?>
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="<?php echo base_url() ?>themes/admin/js/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link href="<?php echo base_url() ?>themes/admin/css/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>themes/admin/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>themes/admin/css/response.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo base_url() ?>themes/admin/favicon/favicon_symbol.png" />

</head>
<!-- end::Head -->

<!-- end::Body -->
<!-- end::Body -->

<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
	<input type="hidden" id="base_url" value="<?php echo base_url();?>" />	
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">

        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(<?php echo base_url() ?>themes/admin/img/bg/bg-3.jpg);">
            <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="<?php echo base_url() ?>">
                           <img height="90" src="<?php echo base_url() ?>./themes/admin/logo/color_logo_transparent.png">  
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <?php if(isset($error) && $error): ?>
							<div class="alert alert-warning alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<strong>Oops...</strong> <?php echo $error; ?>
							</div>
						<?php endif; ?>
						<?php if(isset($success) && $success): ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<strong></strong> <?php echo $success; ?>
							</div>							
							<script>
								setTimeout(function(){
									location.href=$('#base_url').val();
								},6000)
							</script>
							
						<?php endif; ?>						                  						
                    </div>                                       
                </div>
            </div>
        </div>
    </div>   
    <script src="<?php echo base_url() ?>themes/admin/js/vendors.bundle.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>themes/admin/js/scripts.bundle.js" type="text/javascript"></script>    
    <script src="<?php echo base_url() ?>themes/admin/js/login.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>themes/admin/lib/base/toastr.js" type="text/javascript"></script>	
</body>
</html>
