$(document).ready(function () {
    if ($.cookie("rmbUser") == "true") {
    	// alert($.cookie("password"));
        $("#ck_rmbUser").attr("checked", true);
        // $("#username").val($.cookie("username"));
        $("#username").attr("value",$.cookie("username"));
        // $("#userpassword").val($.cookie("password"));
        $("#userpassword").attr("value",$.cookie("password"));
        
        // window.location.href = "../Index/index";
    }
});

// function changeImgCode(){
// 	var imgCode=$("#imgCode");
// 	imgCode.attr("src",imgCode.attr("src") + '?' + Math.floor(Math.random()*100));
// }

function login() {
	var username = $("#username").val();
	var password = $("#userpassword").val();
	var verify = $("#security-code input[name='verify']").val();
	//var token = $("#security-code").val();
     
  //    var xz=document.getElementById("ck_rmbUser"); 
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
		url: Think.U('/Home/Login/tologin'),
		data:{
			username : username,
			password: password,
			verify:verify
            //token: token
		},
		success : function(data) {
			
			if (data.status=='1') {
			    window.location.href = "../Index/index";
			    
                //window.prompt(json.message);
			} else if(data.status=='2'){
				alert("验证码错误！");
			}else {
				alert("用户名或密码错误！");
			}
		}
	    
	});
}


