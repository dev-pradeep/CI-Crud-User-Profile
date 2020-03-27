$(document).ready(function() {
	setDatatable();	
	$('#fa-spin').hide();
	$("body").on("click","#btn-add-user",function(event){
		$('.m-bootstrap-select').selectpicker('deselectAll');
	})
	$("body").on("click","#add_user",function(event){
		if (isDoubleClicked($(this))) return;
		if($("#Adduser-form").valid()){
			Adduser();	
		}		
	});
	$("body").on("click","#cuns_btn",function(event){
		$("#Adduser-form")[0].reset();	
	});
	$("body").on("click","a.userEdit",function(e){
		e.preventDefault()
		var userData = $(this).data('user');		
		$("#admin_id").val(userData.admin_id);	
		$("#user_name").val(userData.name);	
		$("#user_email").val(userData.email);					
		$("#user_address").val(userData.address);
		$("#user_phone_no").val(userData.mobile_no);				
		var verified = userData.status;	
		if(verified == 1){			
			$('#isVerified').prop('checked', true);
		}else{			
			$('#isVerified').prop('checked', false);
		}
	});
	
	$("body").on("click","#update-user",function(event){
		if (isDoubleClicked($(this))) return;
		if($("#edit-user-form").valid()){
			Updateuser();
		}		
	});
	
	$("body").on("click", "a.user_delete", function() {
		var userData = $(this).data('user');
		var user_id = userData.admin_id;
		$("#user_id").val(user_id);
	});
	$("body").on("click", "a.active", function() {
		var userData = $(this).data('user');
		var admin_id = userData.admin_id;
		activeStatus(admin_id)
	});
	$("body").on("click", "a.inactive", function() {
		var userData = $(this).data('user');
		var admin_id = userData.admin_id;
		inactiveStatus(admin_id)
	});
	$("body").on("click", "#delete_user", function() {
		var userId = $("#user_id").val();
		deleteuser(userId);
	});	
	$("body").on("keyup", "#company_name", function() {		
		var myStr = this.value;		
        var space = myStr.toLowerCase();
        var remove_space = space.replace(/ /g,'');
		var str=remove_space.replace(/[^a-z0-9\s]/g, '')
        $("#url").val(str);
	});
	$("body").on("click", "a.change_password", function() {
		var userData = $(this).data('user');
		var admin_id = userData.users_code;
        $('#users_id').val(admin_id);
		$('#chanegpass_consultants').modal('show')
    });
	$("body").on("click", "#resetpass", function() {		
        if (password_match() == true) {
            if ($("#reset_pass").valid()) {
                var url = $('#base_url').val();
                var data = $("#reset_pass").serializeArray();
                $.ajax({
                    type: "post",
                    data: data,
                    url: url + 'admins/changePassword',
                    success: function(data) {
                        if (data.status == "success") {
                            toastr.success(data.message);
                            $('#chanegpass_consultants').modal('hide');
                            $('#newPassword').val('');
                            $('#confirmPassword').val('');                            
                        }
                        if (data.status == "error") {
                            toastr.error(data.message);
                        }
                    }
                });
            }
        }
    });
	// validation Consultants Company start //
	
	jQuery.validator.addMethod("hasLowercase", function(value, element) {
	  return this.optional(element) || /^[^A-Z0-9!@#$%^\/=?_.,:;<>\\-]+$/.test(value);
	}, '<span style="color:red">Please enter a Lowercase Letters Consultants Company</span>'); 
	
	$("#Adduser-form").validate({
	  rules: {
		company_name: {
		  required: true
		},
		name: {
		  required: true
		},
		email: {
		  required: true
		},
		mobile_no: {
		  required: true
		}
	  }
	});
	
	$("#edit-user-form").validate({
	   rules: {
		company_name: {
		  required: true
		},
		name: {
		  required: true
		},
		email: {
		  required: true
		},
		mobile_no: {
		  required: true
		}
	  }
	});
	$("body").on("keyup", "#url", function() {		
		var myStr = this.value;		
        var space = myStr.toLowerCase();
        var remove_space = space.replace(/ /g,'');
		var str=remove_space.replace(/[^a-z0-9\s]/g, '')
        $("#url").val(str);
	});
});
function password_match() {
    if ($('#newPassword').val() == '' || $('#confirmPassword').val() == '') {
        toastr.error("Enter Password");
        return false;
    } else if ($('#newPassword').val() != $('#confirmPassword').val()) {
        toastr.error("Password do not match, please check");
        return false;
    } else {
        return true;
    }
}

sendRegistrationMail();
function sendRegistrationMail(){
	var url = $('#base_url').val();
	$.ajax({
		type: "post",
		data: {},
		url: url + 'admins/sentemail',
		success: function(data) {
			
		}
	});
}
function Adduser(){
	var fdata=$("#Adduser-form").serializeArray();
	var url=$('#base_url').val();
	$("#loader").show();
	$("#add_user").prop('disabled', true);
	$.ajax({
		type:"post",
		data:fdata,
		url: url+'admins/adduser',
		success: function(data){
			if(data.status=="success"){	
				toastr.success(data.message);
				$("#Adduser-form")[0].reset();
				$("#loader").hide();
				$("#add_user").prop('disabled', false);
				$("#newevent").modal('hide');				
				loaduser(1);
				loaduser(0);
				setTimeout(function(){
					sendRegistrationMail();	
				},1000);
			}
			if(data.status=="error"){
				toastr.error(data.message);
				$("#loader").hide();
				$("#add_user").prop('disabled', false);
			}		
		}
	});
}	
function Updateuser(){
	var d=$("#edit-user-form").serializeArray();
	var url=$('#base_url').val();	
	$("#updateloader").show();
	$("#update-user").prop('disabled', true);
	$.ajax({
		type:"post",
		data:d,
		url: url+'admins/updateuser',
		success: function(data){
			if(data.status=="success"){
				toastr.success(data.message);
				$("#updateloader").hide();
				$("#update-user").prop('disabled', false);
				$("#editevent").modal('hide');
				loaduser(1);
				loaduser(0);
			}
			if(data.status=="error"){
				toastr.error(data.message);
				$("#updateloader").hide();
				$("#update-user").prop('disabled', false);
			}	
		}
	});
}
function deleteuser(id) {
	var url = $('#base_url').val();
	var accessTokens = $('input[name="accessToken"]').val();
	$.ajax({
		type: 'post',
		data: {user_id: id,accessToken:accessTokens},
		url: url + 'admins/deleteuser',
		success: function(data) {
			if(data.status=="success"){
				toastr.success(data.message);
				$("#delete_consultants").modal('hide');
				loaduser(1);
				loaduser(0);
			}
			if(data.status=="error"){
				toastr.error(data.message);
			}
		}
	});			
}
function activeStatus(id){
	var url = $('#base_url').val();
	var accessTokens = $('input[name="accessToken"]').val();
	$.ajax({
		type: "post",
		data: {user_id:id,accessToken:accessTokens},
		url: url + 'admins/activeStatus',
		success: function(data) {
			if(data.status=="success"){
				toastr.success(data.message);
				loaduser(1);
				loaduser(0);
			}
			if(data.status=="error"){
				toastr.error(data.message);
			}	
		}
	});
}
function inactiveStatus(id){
	var url = $('#base_url').val();
	var accessTokens = $('input[name="accessToken"]').val();
	$.ajax({
		type: "post",
		data: {user_id:id,accessToken:accessTokens},
		url: url + 'admins/inactiveStatus',
		success: function(data) {
			if(data.status=="success"){
				toastr.success(data.message);
				loaduser(1);
				loaduser(0);
			}
			if(data.status=="error"){
				toastr.error(data.message);
			}	
		}
	});
}
function loaduser(status){
	var url = $('#base_url').val();
	var accessTokens = $('input[name="accessToken"]').val();
	$.ajax({
		type: "post",
		data: {userStatus:status,accessToken:accessTokens},
		url: url + 'admins/loaduser',
		success: function(data) {
			if(status==1){
				$("#userTable").html(data);			
				$('.userData').DataTable( {
					responsive: true
				});
			}else{
				$("#inactiveUserData").html(data);
				$('.inactiveuserData').DataTable( {
					responsive: true
				});
			}
		}
	});
}
function setDatatable(){	
	$('.userData').DataTable( {
		responsive: true
	});
	$('.inactiveuserData').DataTable( {
		responsive: true
	});
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