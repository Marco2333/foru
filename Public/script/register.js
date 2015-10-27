$(document).ready(function(){
	$("#demoForm").validate({
		rules:{
			nickname:{
				required:true,
				maxlength:10
				// remote:"../Login/checkUserExist"
			},
			password:{
				required:true,
				minlength:8,
				maxlength:20
			},
			"confirm-password": {
				equalTo:".user-info-div input[name='password']"
			},
			phone: {
				digits:true,
				maxlength:11,
				minlength:11,
				required:true,
				remote:{                                          //验证用户名是否存在
	               type:"POST",
	               url:"../Login/checkUserIsExist",             //servlet
	               data:{
	                 phone:function(){
	                 	return $("#register-info input[name='phone']").val();
	                 }
	               } 
	             
	            }
			},
			// "security-code": {
			// 	required:true
			// },
			user_protocol:{
				required:true,
			}

		},
		messages:{
			nickname:{
				required:"用户名不能为空",
				maxlength:"用户名长度不能超过10位"
			},
			password:{
				required:"密码不能为空",
				minlength:"密码长度不能低于8位",
				maxlength:"密码长度不能超过20位"
			},
			"confirm-password": {
				equalTo:"两次输入的密码不一致"
			},
			phone: {
				digits:"请输入11位中国大陆手机号",
				maxlength:"请输入11位中国大陆手机号",
				minlength:"请输入11位中国大陆手机号",
				required:"手机号不能为空",
				remote:"该手机号已经被注册"
			},
			// "security-code": {
			// 	required:""
			// },
			user_protocol:{
				required:"请同意协议",
			}
		},
		errorPlacement:function(error, element) {
	        //error是错误提示元素span对象  element是触发错误的input对象
	        //发现即使通过验证 本方法仍被触发
	        //当通过验证时 error是一个内容为空的span元素
	        element.parent().next(".userinfo-behind").text("");
	        error.appendTo(element.parent().next(".userinfo-behind"));
    	},
    	errorClass:"error-info"
	});

	$("#resent-secword").click(function(){
		var val = $("#phone-user-info input").val().trim();
		if(val.length == 0) {
			$('#confirmcode .userinfo-behind').text('手机号不能为空').addClass('error-info');
			return;
		}

		if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(val))) {
			$('#confirmcode .userinfo-behind').text('请输入规范的手机号').addClass('error-info');
			return;
		}

		if($("#phone-user-info label").text()=="该手机号已经被注册") {
			$('#confirmcode .userinfo-behind').text('该手机号已被注册').addClass('error-info');
			return;
		}

		$('#confirmcode .userinfo-behind').text('').removeClass('error-info');

		$(this).val("59秒后重新发送").addClass("sub-number")
			.attr("disabled",true);
		var a = setInterval(function(){
			var num = $("#resent-secword").val().substr(0,2);

			if(parseInt(num)-1<10) {
				$("#resent-secword").val("0"+parseInt(num)-1+"秒后重新发送");
			}
			else if (parseInt(num)-1 >= 10) {
				$("#resent-secword").val(parseInt(num)-1+"秒后重新发送");
			}
			if(parseInt(num)==0) {
				clearInterval(a);
				$("#resent-secword").val("重新获取验证码")
				.removeClass("sub-number").attr("disabled",false);
			}
			
			
		},1000);
	});


	$("#user-protocol-input").click(function() { 
		// promptMessage();
		if(document.getElementById("user-protocol-input").checked){
			$("#button-register").css("background-color","#24dfc2");
			$("#button-register").attr("disabled", false);
		}
		else{
			$("#button-register").css("background-color","#ddd");
			$("#button-register").attr("disabled", true);
		}
	});
	// $("#register-info input[name='phone']").blur(function(){
	// 	checkUserExist();
	// });

	// $("#register-info input[name='mail']").blur(function(){
	// 	checkMailExist();
	// });

	// $("#button-register").click(function(){
	// 	checkMailExist();
	// });
})

function checkUserExist(){
	var phone = $("#register-info input[name='phone']").val();
	alert("s");
	$.ajax({
		type:"POST",
		url: "../Login/checkUserExist",
		data: {
			phone:phone
		},
		success: function(data){
			var json = eval(data);
			if(json.status==0){	
				alert(json.status);
				return true;
			}
			else {
				return false;
			}
		}
	});
}

function checkMailExist(){
	var mail = $("#register-info input[name='mail']").val();
	$.ajax({
		type:"POST",
		url: "../Login/checkMailExist",
		data: {
			mail:mail
		},
		success: function(data){
			var json = eval(data);
			if(json.status==0){	
				$(".userinfo-behind[name='mail_message']").html("<label class='error-info'>该邮箱已经被注册</label>");
				$("#register-info input[name='mail']").val("");
			}
		}
	});
}