var $uploadCrop;
$(document).ready(function() {
	$('#submitprofile').click(function() {
        if (profilename() == true) {
			if (isDoubleClicked($(this))) return;
            updateadminprofile();
		}
	});
    $('#resetpass').on('click', function() {
        if (password_match() == true) {
            //if ($("#reset_pass").valid()) {
				if (isDoubleClicked($(this))) return;
                var url = $('#base_url').val();
                var data = $("#reset_pass").serializeArray();
				$("#resetlodaer").show();
				$("#resetpass").prop('disabled', true);
                $.ajax({
                    type: "post",
                    data: data,
                    url: url + 'admins/changePassword',
                    success: function(data) {
                        if (data.status == "success") {
                            toastr.success(data.message);
							$("#resetlodaer").hide();
							$("#resetpass").prop('disabled', false);
                            $('#newPassword').val('');
                            $('#confirmPassword').val('');
						}
                        if (data.status == "error") {
                            toastr.error(data.message);
							$("#resetlodaer").hide();
							$("#resetpass").prop('disabled', false);
						}
					}
				});
			//}
		}
	});
	$("body").on("change", "#upload", function() {
        readFile(this);
	})
	$("body").on("click", ".profile_model", function() {
        $('#upload-demo').html('')
        var urls = $(this).attr('src');
        var profileimg = $(this).attr('profile_img');
        setTimeout(function() {
            $('#image_name').val(profileimg)
            var uploaelemnt = document.getElementById('upload-demo');
            $uploadCrop = new Croppie(uploaelemnt, {
                viewport: {
                    width: 200,
                    height: 200
				},
                boundary: {
                    width: 300,
                    height: 300
				}
			});
            $uploadCrop.bind({
                url: urls,
                orientation: 4
			});
		}, 500)
	});
	$("body").on("click", "#Upload_adminimage", function() {
        if ($('#upload_imgval').val() == 1) {
            croploadimg();
		}
        setTimeout(function() {
			if (isDoubleClicked($(this))) return;
            uploadimg();
		})
	});
});
function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $uploadCrop.bind({
                url: e.target.result
			});
            $('.upload-demo').addClass('ready');
            $('#upload_imgval').val(1)
		}
        reader.readAsDataURL(input.files[0]);
	}
}
function croploadimg() {
    $uploadCrop.result('base64').then(function(base64) {
        $('#imagebase64').val(base64);
	});
}
function updateadminprofile() {
    var url = $('#base_url').val();
	var data = $("#submit_profile_data").serializeArray();
	$("#update_profileLoader").show();
	$("#submitprofile").prop('disabled', true);
    $.ajax({
        type: "post",
        data: data,
        url: url + 'admins/change_profile_data',
        success: function(data) {
            if (data.status == "success") {
				$("#update_profileLoader").hide();
				$("#submitprofile").prop('disabled', false);
                toastr.success(data.message);
                $('#username').html(data.data.name);
			}
            if (data.status == "error") {
				$("#update_profileLoader").hide();
				$("#submitprofile").prop('disabled', false);
                toastr.error(data.message);
			}
		}
	});
}
function uploadimg() {
    var urls = $('#base_url').val();
    var formda = new FormData($("#submit_profile_img")[0]);
	$("#update_imageLoader").show();
	$("#Upload_adminimage").prop('disabled', true);
    $.ajax({
        type: "post",
        data: formda,
        url: urls + 'admins/update_user_profile',
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.status == "success") {
                toastr.success(data.message);
                $('#image_name').val(data.data.fileName);
                var imagePath = urls + 'uploads/adminLogo/' + data.data.profile_pic;
                $('#profilepic1').attr('src', imagePath);
                $('#profilepic2').attr('src', imagePath);
                $('#Modals_Img').attr('src', imagePath);
				$("#update_imageLoader").hide();
				$("#Upload_adminimage").prop('disabled', false);
                $("#profile_image").modal('hide');
            }
            if (data.status == "error") {
                toastr.error(data.message);
				$("#update_imageLoader").hide();
				$("#Upload_adminimage").prop('disabled', false);
			}
		}
	});
}
function password_match() {
	if ($('#newPassword').val() == '' || $('#confirmPassword').val() == '') {
		toastr.error("Enter Password");
		return false;
        } else if ($('#newPassword').val().length < 4 || $('#confirmPassword').val().length < 4) {
		toastr.error("Password must contain at least four characters!");
        } else if ($('#newPassword').val() != $('#confirmPassword').val()) {
		toastr.error("Password do not match, please check");
		return false;
        } else {
		return true;
	}
}
//valadation for name
function profilename() {
    re = /[a-z && A-Z]/;
    if ($('#name').val() == '' && $('#email').val() == '') {
        toastr.error("The Name field is required. The Email field is required.");
        return false;
		} else if ($('#name').val() == '') {
        toastr.error("The Name field is required");
        return false;
		} else if (!re.test($('#name').val())) {
        toastr.error("Atleast one alphabet required in name");
        return false;
		} else if ($('#email').val() == '') {
        toastr.error("The Email field is required");
        return false;
		} else {
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
