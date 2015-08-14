$(document).ready(function () {
    if ($.cookie("rmbUser") == "true") {
    	// alert($.cookie("password"));
        $("#ck_rmbUser").attr("checked", true);
        // $("#username").val($.cookie("username"));
        $("#username").attr("value",$.cookie("username"));
        // $("#userpassword").val($.cookie("password"));
        $("#userpassword").attr("value",$.cookie("password"));
    }
});

function login() {
	var username = $("#username").val();
	var password = $("#userpassword").val();
	var verify = $("#security-code input[name='verify']").val();
	//var token = $("#security-code").val();     

	if (document.getElementById("ck_rmbUser").checked) {
	    $.cookie("rmbUser", "true", { expires: 7 }); 
	    $.cookie("username", username, { expires: 7 });
	    $.cookie("password", password, { expires: 7 });	   
	}
	else {
	    $.cookie("rmbUser", "false", { expire: -1 });
	    $.cookie("username", "", { expires: -1 });
	    $.cookie("password", "", { expires: -1 });
	}
    
	$.ajax({
		type: "POST",
		url: toLoginUrl,
		data:{
			username : username,
			password: password,
			verify:verify
		},
		success : function(data) {			
			if (data.status=='1') {
			     window.location.href = toIndexUrl;
			} else if(data.status=='2'){
			   $('#info').show();
               $('#info').html("验证码错误");
               setTimeout("$('#info').hide()", 2000 );
			}else {
			   $('#info').show();
               $('#info').html("用户名或者密码错误");
               setTimeout("$('#info').hide()", 2000 );
			}
		}
	    
	});
}


