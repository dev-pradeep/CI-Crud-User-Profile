//Popup box
var myWindow;
$(document).ready(function() {
	$('#btnSignIn').click(function(){
		if (isDoubleClicked($(this))) return;
	 	SignIn();
	});
	$('#m_loginsignup').click(function(){
		if(password_match()==true){
			SignUp();
		}
	});
	$('#btnPopupForgot').click(function(){	
		if (isDoubleClicked($(this))) return;
		ForgotPassword();
	});
	$('body').on("keypress","#uEmail", function (e) {
		if (isDoubleClicked($(this))) return;		
	    if (e.keyCode == 13) {
	        e.preventDefault();
	        SignIn();
		}
	});
	$('body').on("keypress","#uPass", function (e) {   
		if (isDoubleClicked($(this))) return;
	    if (e.keyCode == 13) {
	        e.preventDefault();
	        SignIn();
		}
	});
	$("body").on("click",'#logout',function(){ 
		logout();
	});
	$('.select-plan').click(function(){  
		var plandata = $(this).data('plans');
		var plan_amount=plandata.amount;
		var planname=plandata.plan_name;
		var plans=$('#selected_plan_name').html(plandata.plan_name)
		localStorage.removeItem('planamount');
		localStorage.setItem('planamount',plan_amount);
		localStorage.setItem('planName',planname);
		localStorage.removeItem('planname');
		$('#selected_plan').attr('style','display:block');
		$('#not_selected').attr('style','display:none');
		$('#myModallplan').modal("hide");
		$("#m_loginsignup").hide();
		$("#paymentprocess").show();
	})
	$('#paymentprocess').click(function(){
		if(password_match()==true){
			stripedata();
		}
	});
	$('#reselectplan').click(function(){
		selectplan();
	});
	$('body').on('click','#m_login_signup',function(){
		$('.m-login__wrapper,.m-login__container,m-login__signup').addClass('setwidth')		
	})
	$('body').on('click','#m_login_signup_cancel',function(){
		$('.m-login__wrapper,.m-login__container,m-login__signup').removeClass('setwidth')		
	})
	$('body').on('click','#cancel',function(){
		var url=$('#base_url').val();
		window.location.href = url+'login';
	});
	
});
function logout(){
	var url=$('#base_url').val();
	$.ajax({
		type:"post",
		url: url+'login/logout',
		dataType:'json',
		success: function(data){
			if(data.status=="success"){
				toastr.success(data.message);
				window.location.href = data.data.redirect_url;
			}
			if(data.status=="error"){                                            
				toastr.error(data.message);                
			}
		}
	});
}
function ForgotPassword(){
	var d=$('#frmPopupforgot').serializeArray();
	var url=$('#base_url').val();
	$("#forgot_loader").show();
	$('#btnPopupforgot').prop("disabled",true);
	$.ajax({
		type:"post",
		data:d,
		url: url+'login/forgotpasswords',
		success: function(data){
			if(data.status=="success"){        		
				$('#btnPopupforgot').prop("disabled",false);
				$("#forgot_loader").hide();
				toastr.success(data.message);
			}
			if(data.status=="error"){
				$("#forgot_loader").hide();
				toastr.error(data.message);	
			}			
			$('#btnPopupforgot').prop("disabled",false);
		}
	});	
}
function SignUp(){	
	var d=$('#frmSignup').serializeArray();	
	var url=$('#base_url').val();
	$("#m_loginsignup").prop("disabled",true);	
	$.ajax({
		type:"post",
		data:d,
		url: url+'login/signup',
		success: function(data){        	
			if(data.status=="success"){
				toastr.success(data.message);
				$("#m_loginsignup").prop("disabled",false);
				$('#frmSignup')[0].reset();
				$('#m_login_signup_cancel').click();				
			}
			if(data.status=="error"){
				toastr.error(data.message);			
				$("#m_loginsignup").prop("disabled",false);
			}
			$("#m_loginsignup").prop("disabled",false);
		}
	});	
}
function SignIn(){
	var d=$('#frmSignIn').serializeArray();	
	var url=$('#base_url').val();
	$("#btnSignIn").prop("disabled",true);
	$("#signin_loader").show();
	$.ajax({
		type:"post",
		data:d,
		url: url+'login/signin',
		success: function(data){        	
			if(data.status=="success"){
				toastr.success(data.message);
				$("#btnSignIn").prop("disabled",false);
				$("#signin_loader").hide();
				setTimeout(function(){
					window.location.href = data.redirect_url;
				},1000);
			}
			if(data.status=="error"){											
				toastr.error(data.message);
				$("#btnSignIn").prop("disabled",false);
				$("#signin_loader").hide();
			}
		}
	});	
}
function password_match(){	
	re = /[a-z && A-Z]/;
	if($('#password').val()=='' || $('#re_password').val()==''){
		toastr.error("all fields are required");	
		return false;
		}else if($('#password').val().length < 4 || $('#re_password').val().length < 4){
		toastr.error("Password must contain at least four characters!");
		}else if($('#password').val()!=$('#re_password').val()){
		toastr.error("Password does't match please check");	
		return false;
		}else if(!re.test($('#businessname').val())){
		toastr.error("Atleast one alphabet required in Business name");	
		return false;
		}else if(!re.test($('#fullname').val())){
		toastr.error("Atleast one alphabet required in name");	
		return false;
		}else if($('#iagree').is(':checked')==false){
		toastr.error("Please accept the terms & conditions");	
		return false;
		}else if(!re.test($('#selected_plan_name').html())){
		toastr.error("Select a plan");	
		return false;
		}else{
		return true;
	}
}
function isDoubleClicked(element) {
    //if already clicked return TRUE to indicate this click is not allowed
    if (element.data("isclicked")) return true;

    //mark as clicked for 1 second
    element.data("isclicked", true);
    setTimeout(function () {
        element.removeData("isclicked");
    }, 1000);

    //return FALSE to indicate this click was allowed
    return false;
}									