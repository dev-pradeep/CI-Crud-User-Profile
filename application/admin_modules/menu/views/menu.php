<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
	<input type="hidden" id="base_url" value="<?php echo base_url();?>" />	
	<input type="hidden" name="accessToken"  value="<?php echo $this->session->userdata('accessToken'); ?>">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <img class="navbar-brand-full" src="<?php echo base_url() ?>themes/admin/images/logo.svg" width="89" height="25" alt="CoreUI Logo">
            <img class="navbar-brand-minimized" src="<?php echo base_url() ?>themes/admin/images/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav ml-auto">            
            <?php echo $name; ?>
			<li class="nav-item dropdown">
                <?php
					if(file_exists('uploads/adminLogo/'.($profilepic)))
					{
						if($profilepic){
							$profile_pics = base_url().'uploads/adminLogo/'.$profilepic;													
						}}else{
						$profile_pics = base_url().'uploads/adminLogo/defaultUser.png';
					}																								
				?>
				<a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="img-avatar" src="<?php echo $profile_pics; ?>" />
                </a>
                <div class="dropdown-menu dropdown-menu-right">                    
                    <div class="dropdown-header text-center">
                        <strong>Settings</strong>
                    </div>                    
                    <a class="dropdown-item" href="<?php echo base_url('setting');?>">
                        <i class="fa fa-wrench"></i> Settings</a>                    
                    <a class="dropdown-item" href="<?php echo base_url('login/logout');?>">
                        <i class="fa fa-lock"></i> Logout</a>
                </div>
            </li>
        </ul>        
    </header>
	<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link"  href="<?php echo base_url('admins/dashboard');?>">
                        <i class="nav-icon icon-speedometer"></i> Dashboard                        
                    </a>
                </li> 
				<li class="nav-item">
                    <a class="nav-link"  href="<?php echo base_url('admins/users');?>">
                        <i class="nav-icon icon-speedometer"></i> Users                        
                    </a>
                </li>                
            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
	<script src="<?php echo base_url() ?>themes/admin/js/signin.js" type="text/javascript"></script>