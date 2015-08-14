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
				required:true
			},
			"security-code": {
				required:true
			},
			mail: {
				email:true
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
				required:"手机号不能为空"
			},
			"security-code": {
				required:""
			},
			mail:{
				email:"请输入规范的邮箱号"
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
	})
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
	})
	$("#register-info input[name='phone']").blur(function(){
		checkUserExist();
	});

	$("#register-info input[name='mail']").blur(function(){
		checkMailExist();
	})
})

function checkUserExist(){
	var phone = $("#register-info input[name='phone']").val();
	$.ajax({
		type:"POST",
		url: "../Login/checkUserExist",
		data: {
			phone:phone
		},
		success: function(data){
			var json = eval(data);
			if(json.status==0){	
				$(".userinfo-behind[name='message']").html("<label class='error-info'>该手机号已经被注册</label>");
				 $("#register-info input[name='phone']").val("");
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